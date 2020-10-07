<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\FAQ;
use App\SiteOptions;
use App\Config;

class CMSPagesController extends Controller
{
    // faq setup
    public function faq(Request $request){
        // get all FAQs
        $faqs = FAQ::orderBy('id', 'DESC')->get();
        return view('cms/pages/faq')->with('data', [
            'faqs' => $faqs
        ]);
    }

    // createFaq
    public function createFaq(Request $request){
        $data = $request->validate([
            'question' => ['required', 'string'],
            'answer' =>  ['required', 'string']
        ]);
        // create faq
        $faq = new FAQ();
        $faq->question = $data['question'];
        $faq->answer = $data['answer'];
        $faq->save();

        return redirect(route('pages.faq'))->with('success', 'New FAQ has been created');
    }

    // updateFaq
    public function updateFaq(Request $request){
        $data = $request->validate([
            '_question' => ['required', 'string'],
            '_answer' =>  ['required', 'string']
        ]);

        $id = $request->input('faq_id');
        $faq = FAQ::findorfail($id);
        $faq->question = $data['_question'];
        $faq->answer = $data['_answer'];
        $faq->save();

        return redirect(route('pages.faq'))->with('success', 'New FAQ has been updated');
    }

    // deleteFaq
    public function deleteFaq(Request $request){
        $id = $request->input('faq_id');
        $faq = FAQ::findorfail($id);
        $faq->forceDelete();
        return redirect(route('pages.faq'))->with('success', 'FAQ has been deleted');
    }


    // about
    public function about(Request $request){
        $options = SiteOptions::take(1);
        $about = null;
        if($options){
            $about = $options->aboutContent;
        }
    }

    // configs
    public function configs(){
        $config = Config::orderBy("id", "DESC")->first();
        return view("cms/pages/config")->with("data", [
            "config" => $config
        ]);
    }
}
