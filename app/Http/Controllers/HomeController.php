<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use App\Category;
use App\Location;
use App\Sponsor;
use App\Sponsorship;
use App\Subcategory;
use App\SponsorshipReview;
use App\SponsorCart;
use App\Wallet;
use App\Profile;
use App\User;
use App\Traits\GlobalTrait;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    use GlobalTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get sposnorships
        $sponsorships = Sponsorship::orderBy("id", "DESC")->take(3)->get();
        // get sponsor statistics
        $stats = $this->getSponsorStats();
        return view('home')->with('data', [
            "stats" => $stats,
            "sponsorships" => $sponsorships,
        ]);
    }

    // showSingleSponsorship
    public function showSingleSponsorship($id){
        $sponsorship = Sponsorship::findorfail($id);
        // check of user has added the item to cart in the current session
        $cart_item = SponsorCart::where('sponsorship_id', $id)->where("user_id", Auth::user()->id)->where("session_id", Session::getId())->first();
        return view('sponsorshipPage')->with('data', [
            "sponsorship" => $sponsorship,
            "sponsored_units" => $this->getSponsoredUnits($sponsorship),
            "cart_item" => $cart_item,
        ]);
    }

    // addToSponsorCart
    public function addToSponsorCart(Request $request){
        $session_id = Session::getId();
        $spons_id = $request->input('sponsorship_id');
        $units = intval($request->input('selected_units'));
        // get data about the sponsorship
        $sponsorship = Sponsorship::findorfail($spons_id);
        $capital = $units * $sponsorship->price_per_unit;
        // check if item is available
        // check if sponsorship is active
        if($sponsorship->is_active){
            // check if units are available
            $remSponsUnits = $sponsorship->total_units - $this->getSponsoredUnits($sponsorship);
            if($remSponsUnits >= $units){
                // ensure that the selected units is valid
                if($units > 0){
                    // get data about the sponsorship
                    $sponsorship = Sponsorship::findorfail($spons_id);
                    // check if use has the item in cart
                    $check = SponsorCart::where("user_id", Auth::user()->id)->where("sponsorship_id", $spons_id)->where("session_id", $session_id)->first();
                    if($check){
                        // update cart
                        $cart = SponsorCart::find($check->id);
                    }else{
                        // add to cart
                        $cart = new SponsorCart();
                    }
                    $cart->user_id = Auth::user()->id;
                    $cart->session_id = $session_id;
                    $cart->sponsorship_id = $spons_id;
                    $cart->units = (int)$units;
                    $cart->price_per_unit = $sponsorship->price_per_unit;
                    $cart->expected_return_pct = $sponsorship->expected_returns_pct;
                    $cart->total_capital = $capital;
                    $cart->save();
                    
                    return redirect("/cart")->with("success", "Item added");
                }else{
                    // invalid number of units selected
                    return redirect("/sponsorships/$spons_id")->with("error", "Invalid number of units selected");
                }
            }else{
                // no units available
                return redirect("/sponsorships/$spons_id")->with("error", "Insufficient units available");
            }
        }else{
            // sponsorship is in active
            return redirect("/sponsorships/$spons_id")->with("error", "Sponsorship is in-active");
        }
    }

    // showCartPage
    public function showCartPage(){
        return view("sponsorCart")->with("data", $this->getCartData());
    }

    // removeCartItem
    public function removeCartItem(Request $request){
        $item_id = $request->input('item_id');
        $item = SponsorCart::findorfail($item_id);
        $item->forceDelete();
        return redirect('/cart');
    }

    // checkoutCart
    public function checkoutCart(Request $request){
        $cartData = $this->getCartData();
        if(count($cartData['cart_items']) == 0){
            return redirect("/cart");
        }else{
            return view("checkout")->with("data", $cartData);
        }
    }

    // checkoutWithWallet
    public function checkoutWithWallet(Request $request){
        $password = $request->input("acc_pwd");
        $session_id = Session::getId();
        $tran_ref = $session_id."/".str_shuffle("_adcbefgh");
        // confirm password
        if (Hash::check($password, Auth::user()->password)){
            // check if the user has sufficient balance
            $cartData = $this->getCartData();
            if($this->getWalletBalance() >= $cartData['total_cap']){
                // debit the user
                if($this->debitWallet($cartData['total_cap'], "Capital paid for sponsorship(s) with transaction reference code ".$tran_ref)){
                    // loop through the cart items and move them to the sponsor table
                    foreach ($cartData['cart_items'] as $key => $item) {
                        $sponsor = new Sponsor();
                        $sponsor->user_id = $item->user_id;
                        $sponsor->sponsorship_id = $item->sponsorship_id;
                        $sponsor->units = $item->units;
                        $sponsor->price_per_unit = $item->price_per_unit;
                        $sponsor->expected_return_pct = $item->expected_return_pct;
                        $sponsor->total_capital = $item->total_capital;
                        $sponsor->transaction_id = $tran_ref;
                        $sponsor->transaction_ref_id = $tran_ref;
                        $sponsor->payment_method = "Virtual Wallet";
                        $sponsor->has_paid = true;
                        $sponsor->save();
                        // delete the item from cart
                        $_sponsor = SponsorCart::find($item->id);
                        $_sponsor->forceDelete();
                    }
                    // notify the admin panel of the sponsor entry
                    return redirect("success")
                    ->with("title", "Weldone!!!")
                    ->with("message", "Your sponsorship entry has been created successfully")
                    ->with("link", "/history");
                }else{
                    // error while deducting
                    return redirect('/cart/checkout')->with("error", "Transaction failed. Wallet not available at the moment.");
                }
            }else{
            // insufficient funds
            return redirect('/cart/checkout')->with("error", "Transaction failed. You currently do not have sufficient funds.");
        }
        }else{
            // invalid password
            return redirect('/cart/checkout')->with("error", "Authorization failed. Invalid password entered.");
        }
    }

    // debitWallet
    public function debitWallet($amt, $desc){
        if($this->getWalletBalance() >= $amt){
            $wallet = new Wallet();
            $wallet->user_id = Auth::user()->id;
            $wallet->amount = $amt;
            $wallet->is_credit = false;
            $wallet->description = $desc;
            $wallet->save();
            return true;
        }else{
            return false;
        }
    }

    // cart data
    public static function getCartData(){
        $session_id = Session::getId();
        $cartItems = SponsorCart::where("session_id", $session_id)->where("user_id", Auth::user()->id)->orderBy("id", "DESC")->get();
        // get figures
        $total_cap = 0; $total_units = 0; $total_est_returns = 0;
        foreach ($cartItems as $key => $item) {
            $total_cap += $item->total_capital;
            $total_units += $item->units;
            $total_est_returns += $item->expected_return_pct * $item->total_capital;
        }
        return [
            "cart_items" => $cartItems,
            "total_cap" => $total_cap,
            "total_units" => $total_units,
            "total_est_returns" => $total_est_returns,
        ];
    }

    // createSponsor
    public function createSponsor(Request $request){
        $spons_id = $request->input('sponsorship_id');
        $units = intval($request->input('selected_units'));
        // get data about the sponsorship
        $sponsorship = Sponsorship::findorfail($spons_id);
        // check if sponsorship is active
        if($sponsorship->is_active){
            // check if units are available
            $remSponsUnits = $sponsorship->total_units - $this->getSponsoredUnits($sponsorship);
            if($remSponsUnits >= $units){
                // ensure that the selected units is valid
                if($units > 0){
                    $capital = $units * $sponsorship->price_per_unit;
                    // create new sponsor
                    $sponsor = new Sponsor();
                    $sponsor->user_id = Auth::user()->id;
                    $sponsor->sponsorship_id = $spons_id;
                    $sponsor->units = $units;
                    $sponsor->price_per_unit = $sponsorship->price_per_unit;
                    $sponsor->expected_return_pct = $sponsorship->expected_returns_pct;
                    $sponsor->total_capital = $capital;
                    $sponsor->transaction_id = "TID_73884";
                    $sponsor->transaction_ref_id = "REF_90849";
                    $sponsor->save();

                    return redirect("success")
                    ->with("title", "Weldone!!!")
                    ->with("message", "You have successfully initiated a sponsorship")
                    ->with("link", "/sponsors/$sponsor->id");
                }else{
                    // invalid number of units selected
                    return redirect("/sponsorships/$spons_id")->with("error", "Invalid number of units selected");
                }
            }else{
                // no units available
                return redirect("/sponsorships/$spons_id")->with("error", "Insufficient units available");
            }
        }else{
            // sponsorship is in active
            return redirect("/sponsorships/$spons_id")->with("error", "Sponsorship is in-active");
        }
    }

    // getUserSponsorHistory
    public function getUserSponsorHistory(){
        // get sponsor statistics
        $stats = $this->getSponsorStats();
        // get sponsorships
        $sponsorHistory = Sponsor::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        // featured sponsorships
        $sponsorships = Sponsorship::orderBy("id", "DESC")->take(3)->get();

        // dd($stats);
        return view('sponsorHistory')->with('data', [
            "stats" => $stats,
            "sponsorHistory" => $sponsorHistory,
            "featured_sponsorships" => $sponsorships,
        ]);
    }

    // showSuccessPage
    public function showSuccessPage(){
        return view("success");
    }

    // openSponsorPage
    public function openSponsorPage($id){
        // get sponsor data
        $sponsor = Sponsor::findorfail($id);
        if($sponsor->user_id == Auth::user()->id){
            $remSponsUnits = $sponsor->sponsorship->total_units - $this->getSponsoredUnits($sponsor->sponsorship);
            // get other sponsors for this sponsorship
            $oth_sponsors = Sponsor::where("sponsorship_id", $sponsor->sponsorship->id)->get();
            // loop through to get more data
            $tot_cap = 0;
            foreach ($oth_sponsors as $o_spon) {
                $tot_cap += $o_spon->total_capital;
            } 
            return view('sponsorPage')->with('data', [
                "sponsor" => $sponsor,
                "other_sponsors" => $oth_sponsors,
                "remSponsUnits" => $remSponsUnits,
                "claimed_units" => $this->getSponsoredUnits($sponsor->sponsorship),
                "cap_raised" => $tot_cap,
                "ratings" => $this->calcRating($sponsor->sponsorship),
            ]);
        }else{
            abort(404);
        }
    }

    // addReview
    public function addReview(Request $request){
        $sponsor_id = $request->input("sponsor_id");
        $sponsorship_id = $request->input("sponsorship_id");
        $rating = $request->input("rating");
        $review = $request->input("review");

        $rev = new SponsorshipReview();
        $rev->user_id = Auth::user()->id;
        $rev->sponsorship_id = $sponsorship_id;
        $rev->is_author_sponsor = true;
        $rev->num_stars = (int)$rating;
        $rev->review = $review;
        $rev->save();

        return redirect("/sponsors/$sponsor_id");
    }

    // get initials
    public static function getInitials($name){
        $arr = explode(" ",$name);
        $initials = "";
        for($i = 0; $i < 2; $i++){
            $initials .= substr($arr[$i], 0, 1);
        }
        return $initials;
    }

    // show stars
    public static function showStars($num_stars){
        $stars = "";
        for($i = 0; $i < $num_stars; $i++){
            $stars .= '<span class="fa fa-star yellow-ic"></span>';
        }
        return $stars;
    }

    // userProfile
    public function userProfile(){
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $states    = ['AB' => 'Abia','AJ' => 'Abuja','AN' => 'Anambra','AD' => 'Adamawa','AK' => 'Akwa Ibom','BA' => 'Bauchi','BY' => 'Bayelsa','BE' => 'Benue','BO' => 'Borno','CR' => 'Cross River','DE' => 'Delta','ED' => 'Edo','EK' => 'Ekiti','EB' => 'Ebonyi','EN' => 'Enugu','GO' => 'Gombe','IM' => 'Imo','KN' => 'Kano','LA' => 'Lagos','NS' => 'Nassarawa','JI' => 'Jigawa','KB' => 'Kebbi','KD' => 'Kaduna','KG' => 'Kogi','KT' => 'Katsina','KW' => 'Kwara','NR' => 'Niger','OG' => 'Ogun','ON' => 'Ondo','OS' => 'Osun','OY' => 'Oyo','PL' => 'Plateau','RV' => 'Rivers','SO' => 'Sokoto','TA' => 'Taraba','YB' => 'Yobe','ZM' => 'Zamfara'];
        $relationships = array("Parent",        "Sibling",        "Relative",        "Spouse",        "Child");
        return view('profile')->with('data', [
            "countries" => $countries,
            "states" => $states,
            "rels" => $relationships,
        ]);
    }

    // update user profile
    public function updateUserProfile(Request $request){
        // get user's profile
        $userProfile = Profile::where("user_id", Auth::user()->id)->first();
        if($userProfile){
            $profile = Profile::findorfail($userProfile->id);
        }else{
            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
            $profile->gender = $request->input("gender");
        }
            // update user bio
            $user = User::findorfail(Auth::user()->id);
            $user->name = $request->input("fullname");;
            $user->save();

            $profile->dob = $request->input("dob");
            $profile->phone_no = $request->input("phone");
            $profile->nationality = $request->input("nationality");
            $profile->occupation = $request->input("occupation");
            $profile->country = $request->input("country");
            $profile->address = $request->input("address");
            $profile->state = $request->input("statepro");
            $profile->city = $request->input("city");
            $profile->account_name =  $request->input("acctname");
            $profile->account_number =  $request->input("acctnunber");
            $profile->bank_name =  $request->input("bankname");
            $profile->bvn =  $request->input("bvn");
            $profile->nok_surname = $request->input("nxtsname");
            $profile->nok_firstname = $request->input("nxtfname");
            $profile->nok_relationship = $request->input("relatnsp");
            $profile->nok_email = $request->input("nxtemail");
            $profile->nok_phone = $request->input("nxtphone");
            $profile->nok_address = $request->input("nxtaddress");
            $profile->facebook = $request->input("facebook");
            $profile->twitter = $request->input("twitter");
            $profile->instagram = $request->input("instagram");
            $profile->linkedin = $request->input("linkedin");
            $profile->save();
        
            return redirect("/profile")->with("success", "Profile Updated successfully");
    }

    // updateUserAvatar
    public function updateUserAvatar(Request $request){
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
        ]);
        $dir = "avatars";
        $image = $request->file('avatar');
        $ext = $image->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->put("/", $image);
        $storagePath = env("APP_URL")."/storage//".$imagePath;
        $userProfile = Profile::where("user_id", Auth::user()->id)->first();
        if($userProfile){
            // check if user has previously set an avatar
            $avatar_check = Auth::user()->profile->avatar_file_name;
            if(strlen($avatar_check) > 0){
                    // delete file from the filesystem
                    Storage::disk('public')->delete($avatar_check);
            }
            $profile = Profile::findorfail($userProfile->id);
        }else{
            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
        }
        $profile->avatar_url = $storagePath;
        $profile->avatar_file_name = $imagePath;
        $profile->save();

        return redirect("/profile")->with("success", "Profile photo Updated successfully");
    }

}
