<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\Category;

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
        $cats = Category::orderBy("category_name", "ASC")->get();
        return $cats;
    }

    // showCategory
    public function showCategory(Request $request){
        return view('cms/category')->with('data',[
            "toggle_mode" => $request->input('toggle-mode'),
            "target" => $request->input('target'),
            "autoToggle" => $request->input('auto-toggle'),
        ]);
    }
}
