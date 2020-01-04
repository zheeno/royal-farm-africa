<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Location;
use App\Sponsor;
use App\Sponsorship;
use App\Subcategory;
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
}
