<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Location;
use App\Sponsor;
use App\Sponsorship;
use App\Subcategory;
use App\FAQ;
use App\Config;
use App\Traits\GlobalTrait;

class GuestController extends Controller
{
    use GlobalTrait;

    // landing page
    public function landing(){
        // featured sponsorships
        $sponsorships = Sponsorship::orderBy("id", "DESC")->take(3)->get();

        return view("welcome")->with('data', [
            "featured_sponsorships" => $sponsorships,
        ]);
    }


    // showSponsorships
    public function showSponsorships(Request $request){
        $id = $request->input("id");
        $input = $request->input();
        $category = Category::first();
        if($category){
            $subcategories = Subcategory::orderBy("sub_category_name", "ASC")->get();
            $sponsorships = []; $curCatId = 0; $curSubCat = null; $subs = [];
            foreach ($subcategories as $key => $subCat) {
                // get category
                $cat = Category::where("id", $subCat->category_id)->first();
                if($cat){
                    if($subCat){
                        array_push($subs, $subCat);
                    }
                }
            }
            if($id == null){
                // get all sponsorships
                $sponsorships = Sponsorship::where('is_completed', false)->orderBy('is_active', 'DESC')->orderBy('id', 'DESC')->paginate(12);
            }else{
                // get wrt selected subcategory
                $sponsorships = Sponsorship::where("category_id", $category->id)->where('sub_category_id', $id)->where('is_completed', false)->orderBy('id', 'DESC')->paginate(12);//->where('in_progress', false)
                $curCatId = $id;
                $curSubCat = Subcategory::findorfail($curCatId);
            }
            $sponsorships->appends($input);
            return view('sponsorships')->with('data', [
                "sub_cats" => $subs,
                "sponsorships" => $sponsorships,
                "current_cat_id" => $curCatId,
                "cur_sub_category" => $curSubCat,
            ]);
        }else{
            abort(404);
        }
    }

    // show FAQ page
    public function faqs(){
        $faqs = FAQ::orderBy('id', 'DESC')->get();
        return view('faqs')->with('data', [
            'faqs' => $faqs
        ]);
    }

    // show contact page
    public function contact(Request $request){
        return view('contact');
    }

    // get footer info
    public function footerInfo(){
        $config = Config::orderBy('id', 'DESC')->first();
        return $config;
    }
}
