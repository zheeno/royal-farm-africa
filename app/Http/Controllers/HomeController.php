<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Location;
use App\Sponsor;
use App\Sponsorship;
use App\Subcategory;
use App\SponsorshipReview;
use App\Traits\GlobalTrait;

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
        // check if user has sponsored this
        $sponsored = Sponsor::where("sponsorship_id", $id)->where('user_id', Auth::user()->id)->take(1)->get();
        if(count($sponsored) > 0){
            return redirect("/sponsors/".$sponsored[0]->id);
        }else{
            return view('sponsorshipPage')->with('data', [
                "sponsorship" => $sponsorship,
                "sponsored_units" => $this->getSponsoredUnits($sponsorship),
            ]);
        }
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
        $remSponsUnits = $sponsor->sponsorship->total_units - $this->getSponsoredUnits($sponsor->sponsorship);
        // get other sponsors for this sponsorship
        $oth_sponsors = Sponsor::where("sponsorship_id", $sponsor->sponsorship->id)->get();
        // loop through to get more data
        $tot_cap = 0;
        foreach ($oth_sponsors as $o_spon) {
            $tot_cap += $o_spon->total_capital;
        } 
        if($sponsor->user_id == Auth::user()->id){
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
}
