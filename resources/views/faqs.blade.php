@extends('layouts.app')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | FAQs</title>
@endsection

@section('content')
<div class="container p-5">
    <div class="row p-md-5">
        <div class="col-md-10 mx-auto p-md-2">
            <h1 class="fa-5x text bold">Frequently Asked Questions</h1>
            <p class="lead">If you have any questions regarding our platform and services,
                we&apos;re confident you&apos;ll find them here. If you don&apos;t, feel free
                to <a href="{{route('contact')}}">contact us</a>.
            </p>
        </div>
    </div>
    <div class="row mb-5 pb-5">
        <div class="col-md-9 mx-auto">
        @foreach($data['faqs'] as $index => $faq)
        <div class="row border-bottom grey lighten-5 my-1 mb-3">
            <div class="col-12 pb-2 shadow-sm grey lighten-3">
                <a class="bold h4-responsive" onClick="$('#faq_col_ans_{{$index}}').collapse('toggle')">{{$faq->question}}</a>
            </div>
            <div id="faq_col_ans_{{$index}}" class="my-3 px-4 col-12 collapse">
                {!! $faq->answer !!}
            </div>
        </div>
        @endforeach
        </div>
    </div>
</div>
@endsection