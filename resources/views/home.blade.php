@extends('layouts.investor')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
@endsection

@section('content')
<div class="container-fluid">
    <!-- notify user if profile has not been setup -->
    @if(!Auth::user()->profile)
    <div class="alert alert-info align-text-center">
        <span>Your Profile has not been setup. </span> To have access to all of our features, kindly click <strong><a href="/profile">here</a></strong> to complete your profile.
    </div>
    @else
        @include('inc/userProfileInfo')
    @endif
    <!-- statistics -->
    <div class="row">
        @include('inc/statsScreen')
    </div>
    <!-- featured sponsorships -->
    @if(count($data['sponsorships']) > 0)
    <div class="row p-3 p-md-5 pt-5 pb-5 grey lighten-5">
        <div class="col-12 mb-5">
            <h1 class="fa-2x text">Featured Sponsorships
            <small class="fs-14 float-right"><a href="/sponsorships">See More <span class="fa fa-arrow-right"></span></a></small>
            </h1>
        </div>
        <?php $delay = 0.6; ?>
        @foreach($data['sponsorships'] as $item)
            @include('inc/itemCard')
            <?php $delay += 0.6; ?>
        @endforeach
    </div>
    @endif
</div>
@endsection
