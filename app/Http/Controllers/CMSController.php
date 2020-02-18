<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\Category;
use App\Subcategory;
use App\Sponsorship;
use App\Sponsor;
use App\Location;
use App\Profile;
use App\User;
use App\Notification;

class CMSController extends Controller
{
    // display dashboard
    public function dashboard(){
        $transactions = Wallet::orderBy('id', 'DESC')->take(5)->get();

        return view('cms/index')->with('data', [
            'transactions' => $transactions
        ]);
    }


    // getCategories
    public static function getCategories(){
        $cats = Category::withTrashed()->orderBy("category_name", "ASC")->get();
        return $cats;
    }

    // getSubCategories
    public static function getSubCategories($cat_id){
        $sub_cats = Subcategory::withTrashed()->where("category_id", $cat_id)->orderBy("sub_category_name", "ASC")->get();
        return $sub_cats;
    }

    // getSponsorshipData
    public static function getSubCatSponsorshipData($sub_id){
        // get sponsorship
        $sponsorships = Sponsorship::withTrashed()->where("sub_category_id", $sub_id)->get();
        $total_units = 0; $total_capital = 0; $total_returns = 0; $active_sponsorships_count = 0;

        foreach ($sponsorships as $key => $sponsorship) {
            // get sponsors
            $sponsors = Sponsor::where("sponsorship_id", $sponsorship->id)->get();
            if(!$sponsorship->is_completed){ $active_sponsorships_count++; }
            foreach ($sponsors as $key => $sponsor) {
                $total_units += $sponsor->units;
                $total_capital += $sponsor->total_capital;
                $total_returns += $sponsor->actual_returns_received;
            }
        }

        return [
            "total_sponsorships_count" => count($sponsorships),
            "active_sponsorships_count" => $active_sponsorships_count,
            "total_units" => $total_units,
            "total_capital" => $total_capital,
            "total_returns" => $total_returns,
        ];
    }

    // word wrap and format
    public static function wrap_strip($string, $max_len = 200){
        $text = strip_tags($string);
        if(strlen($text) >= $max_len){
            $pos=strpos($text, ' ', $max_len);
            return nl2br(substr($text,0,$pos )."..."); 
        }else{
            return nl2br($text);
        }
    }

    // showCategory
    public function showCategories(Request $request){
        $cats = Category::withTrashed()->orderBy("category_name", "ASC")->get();
        return view('cms/categories')->with('data',[
            "toggle_mode" => $request->input('toggle-mode'),
            "target" => $request->input('target'),
            "autoToggle" => $request->input('auto-toggle'),
            "categories" => $cats,
        ]);
    }

    // newCategory
    public function newCategory(Request $request){
        $cat_name = $request->input('cat_name');
        $tag_line = $request->input('tag_line');
        $cover_img_url = $request->input('cover_img_url');
        $video_url = $request->input('video_url');
        $desc = $request->input('desc');

        $cat = new Category();
        $cat->category_name = $cat_name;
        $cat->tag_line = $tag_line;
        $cat->description = $desc;
        $cat->cover_image_url = $cover_img_url;
        $cat->video_url = $video_url;
        $cat->save();

        return redirect('/cms/categories')->with('success', 'You have successfully created <b>'.$cat_name.'</b> category');
    }

    // deleteCategory
    public function deleteCategory(Request $request){
        $id = $request->input('id');
        $cat = Category::findorfail($id);
        $cat->delete();
        return redirect('/cms/categories')->with('success', 'You have successfully deleted <b>'.$cat->category_name.'</b> category');
    }

    // restoreCategory
    public function restoreCategory(Request $request){
        $id = $request->input('id');
        $cat = Category::withTrashed()->findorfail($id);
        $cat->restore();
        return redirect('/cms/categories/'.$id)->with('success', 'You have successfully restored <b>'.$cat->category_name.'</b> category');
    }

    // openSelectedSubCategory
    public function openSelectedSubCategory($cat_id, $sub_id){
        $cat = Category::withTrashed()->findorfail($cat_id);
        $sub_cat = Subcategory::withTrashed()->where("id", $sub_id)->where('category_id', $cat_id)->first();
        if($sub_cat){
            $sponsorships = Sponsorship::withTrashed()->where("category_id", $cat_id)->where("sub_category_id", $sub_id)->paginate(12);
            // get locations
            $locs = Location::orderBy("location_name", "ASC")->get(); 
            return view('cms/subcategoryPage')->with("data", [
                "category" => $cat,
                "sub_category" => $sub_cat,
                "sponsorships" => $sponsorships,
                "locations" => $locs,
            ]);
        }else{
            return abort(404);
        }
    }

    // newSubCategory
    public function newSubCategory(Request $request){
        $cat_id = $request->input('cat_id');
        $sub_cat_name = $request->input('sub_cat_name');
        $tag_line = $request->input('tag_line');
        $cover_img_url = $request->input('cover_img_url');
        $video_url = $request->input('video_url');
        $desc = $request->input('desc');

        $sub_cat = new Subcategory();
        $sub_cat->category_id = $cat_id;
        $sub_cat->sub_category_name = $sub_cat_name;
        $sub_cat->video_tag_line = $tag_line;
        $sub_cat->description = $desc;
        $sub_cat->cover_image_url = $cover_img_url;
        $sub_cat->video_url = $video_url;
        $sub_cat->save();

        return redirect('/cms/categories/'.$cat_id)->with('success', 'You have successfully created <b>'.$sub_cat_name.'</b> subcategory');
    }


    // updateSubCategory
    public function updateSubCategory(Request $request){
        $cat_id = $request->input('cat_id');
        $sub_id = $request->input('sub_id');
        $sub_cat_name = $request->input('sub_cat_name');
        $tag_line = $request->input('tag_line');
        $cover_img_url = $request->input('cover_img_url');
        $video_url = $request->input('video_url');
        $desc = $request->input('desc');

        $sub_cat = Subcategory::withTrashed()->findorfail($sub_id);
        if($sub_cat->category_id == $cat_id){
            $sub_cat->category_id = $cat_id;
            $sub_cat->sub_category_name = $sub_cat_name;
            $sub_cat->video_tag_line = $tag_line;
            $sub_cat->description = $desc;
            $sub_cat->cover_image_url = $cover_img_url;
            $sub_cat->video_url = $video_url;
            $sub_cat->save();
        return redirect('/cms/categories/'.$cat_id."/".$sub_id)->with('success', 'Your changes have been saved');
        }else{
            return abort(404);
        }
    }

    // deleteSubCategory
    public function deleteSubCategory(Request $request){
        $id = $request->input('id');
        $sub_cat = Subcategory::findorfail($id);
        $sub_cat->delete();
        return redirect('/cms/categories/'.$sub_cat->category_id)->with('success', 'You have successfully deleted <b>'.$sub_cat->sub_category_name.'</b> subcategory');
    }

    // restoreSubCategory
    public function restoreSubCategory(Request $request){
        $id = $request->input('id');
        $sub_cat = Subcategory::withTrashed()->findorfail($id);
        $sub_cat->restore();
        return redirect('/cms/categories/'.$sub_cat->category_id.'/'.$id)->with('success', 'You have successfully restored this subcategory');
    }

    // updateCategory
    public function updateCategory(Request $request){
        $cat_id = $request->input('cat_id');
        $cat_name = $request->input('cat_name');
        $tag_line = $request->input('tag_line');
        $cover_img_url = $request->input('cover_img_url');
        $video_url = $request->input('video_url');
        $desc = $request->input('desc');

        $cat = Category::findorfail($cat_id);
        $cat->category_name = $cat_name;
        $cat->tag_line = $tag_line;
        $cat->description = $desc;
        $cat->cover_image_url = $cover_img_url;
        $cat->video_url = $video_url;
        $cat->save();

        return redirect('/cms/categories/'.$cat_id)->with('success', 'You have successfully updated <b>'.$cat_name.'</b> category');
    }

    // openSelectedCategory
    public function openSelectedCategory($id){
        $cat = Category::withTrashed()->findorfail($id);

        return view('cms/categoryPage')->with('data',[
            'category' => $cat,
        ]);
    }

    // newSponsorship
    public function newSponsorship(Request $request){
        $sub_id = $request->input("sub_id");
        $cat_id = $request->input("cat_id");
        $title = $request->input("title");
        $tot_units = $request->input("tot_units");
        $duration = $request->input("duration");
        $price = $request->input("price");
        $ret_percent = $request->input("ret_percent");
        $comp_date = $request->input("comp_date");
        $location = $request->input("location");
        $desc = $request->input("desc");
        if((int)$tot_units > 0 && (int)$duration > 0 && (int)$price > 0){
            $sponsorship = new Sponsorship();
            $sponsorship->category_id = $cat_id;
            $sponsorship->sub_category_id = $sub_id;
            $sponsorship->title = $title;
            $sponsorship->description = $desc;
            $sponsorship->location_id = $location;
            $sponsorship->total_units = (int)$tot_units;
            $sponsorship->duration_in_months = (int)$duration;
            $sponsorship->price_per_unit = floatval($price);
            $sponsorship->expected_returns_pct = floatval($ret_percent) / 100;
            $sponsorship->expected_completion_date = $comp_date;
            $sponsorship->save();

            return redirect('/cms/categories/'.$cat_id."/".$sub_id)->with("success", "Sponsorship Created with title <b>".$title."</b>");
        }else{
            // invalid data supplied
            return redirect('/cms/categories/'.$cat_id."/".$sub_id)->with("error", "Error encountered while creating sponsorship");
        }
    }

    // openSponsorshipPage
    public function openSponsorshipPage($id){
        $sponsorship = Sponsorship::findorfail($id);
        return view("/cms/sponsorshipPage")->with("data", [
            "sponsorship" => $sponsorship
        ]);
    }

    // updateSponsorshipStatus
    public function updateSponsorshipStatus(Request $request){
        $id = $request->input('spon_id');
        $sponsorship = Sponsorship::findorfail($id);
        $sponsorship->is_active = intval($request->input('is_active'));
        $sponsorship->in_progress = intval($request->input('in_progress'));
        $sponsorship->is_completed = intval($request->input('is_completed'));
        if($sponsorship->is_completed == 1){
            $sponsorship->actual_completion_date = date("Y-m-d h:i:s");
        }else{
            $sponsorship->actual_completion_date = null;
        }
        $sponsorship->save();
        return redirect("/cms/sponsorships/".$id)->with("success", "You have modified the sponsorship status");
    }

    // getSponsorsList
    public function getSponsorsList(Request $request){
        $id = $request->input('spon_id');
        $sponsors_data = [];
        $sponsors = Sponsor::where("sponsorship_id", $id)->orderBy("id", "DESC")->get();
        // loop through sponsors to get more data
        foreach ($sponsors as $key => $sponsor) {
            $user = $sponsor->user;
            $profile = $user->profile;
            array_push($sponsors_data, $sponsor);
        }
        return json_encode([
            "sponsors" => $sponsors_data,
        ]);
    }

    // getSponsorshipPayoutsData
    public function getSponsorshipPayoutsData(Request $request){
        $id = $request->input('spon_id');
        $sponsorship = Sponsorship::findorfail($id);
        $sponsors = json_decode($this->getSponsorsList($request), true);

        return json_encode([
            "sponsorship" => $sponsorship,
            "sponsors_data" => $sponsors
        ]);

    }

    // sponsorsPayoutInitiate
    public function sponsorsPayoutInitiate(Request $request){
        $id = $request->input('spon_id');
        $sponsors_ids = $request->input('sponsors');
        $sponsors_ids = explode(",", $sponsors_ids);
        $useDefault = boolval($request->input('useDefault'));

        $response = json_decode($this->getSponsorshipPayoutsData($request));
        $sponsorship = $response->sponsorship;
        $sponsors = $response->sponsors_data->sponsors;

        // loop through sponsors_ids
        foreach ($sponsors_ids as $key => $sponsor_id) {
            $sponsor = Sponsor::find($sponsor_id);
            // check if sponsor has not received payout
            if(!$sponsor->has_received_returns){
                if($useDefault){
                    $exp_pct = $sponsor->expected_return_pct;
                }else{
                    $exp_pct = floatval($request->input('exp_ret_pct'));
                }
                // check if user has setup their profile 
                $profile = Profile::where("user_id", $sponsor->user_id)->first();
                if($profile){
                    // get sponsored units
                    $units = $sponsor->units;
                    $capital = $sponsor->total_capital;
                    $returns = $capital + ($capital * $exp_pct);
                    // get sponsor from database
                    $sponsor_data = Sponsor::where("id", $sponsor->id)->first();
                    if($sponsor_data){
                        // modify data accordingly
                        $sponsor_data->actual_returns_received = $returns;
                        $sponsor_data->has_received_returns = true;
                        $sponsor_data->save();
                        // add new entry into transactions record table
                        $transact = new Wallet();
                        $transact->user_id = $sponsor->user_id;
                        $transact->amount = $returns;
                        $transact->is_credit = true;
                        $transact->description = "-- CREDIT ALERT --<br /> You have been paid a total of NGN ".number_format($returns, 2)." into your bank account (".$profile->account_number.")";
                        $transact->save();
                        // notify user about the payout
                        $message = "PAYOUT NOTIFICATION<br />".$sponsorship->title." sponsorship has come to an end, and we are glad to inform you that you have been credited a total of  NGN ".number_format($returns, 2)." into your bank account (".$profile->account_number.").<br />We look forward to doing greater things with you.";
                        $notif = new Notification();
                        $notif->user_id = $sponsor->user_id;
                        $notif->message = $message;
                        $notif->link = null;
                        $notif->seen = false;
                        $notif->save();
                    }
                }else{
                    // notify user on the issue
                    $message = "Hello, we are currently attempting to make payouts to our sponsors and we noticed that you have not setup your bank account information.
                    Kindly do so and contact our support center. Thank you.";
                    $notif = new Notification();
                    $notif->user_id = $sponsor->user_id;
                    $notif->message = $message;
                    $notif->link = null;
                    $notif->seen = false;
                    $notif->save();
                }
            }
        }
        $response_update = json_decode($this->getSponsorshipPayoutsData($request));
        return json_encode($response_update, true);
    }
}
