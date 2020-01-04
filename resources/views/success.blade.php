@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Success</title>
@endsection

@section('content')
<div class="container p-5 white">
    <div class="row p-md-5">
        <div class="col-md-7 p-2 success"></div>
        <div class="col-md-5 p-md-2">
            <h1 class="fa-5x text bold">@if(@session('title')) {{ @session('title') }} @else {{ "Success" }} @endif</h1>
            <h1 class="fa-3x text">@if(@session('message')){!! @session('message') !!} @else {{ "Operation successful" }} @endif</h1>
            <a class="btn green-btn" href="@if(@session('link')){{ @session('link') }} @else {{ '/' }} @endif">Continue</a>
        </div>
    </div>
</div>
@endsection