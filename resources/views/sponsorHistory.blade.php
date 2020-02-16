@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Sponsor History</title>
@endsection
<?php use App\Http\Controllers\HomeController; ?>
@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('inc/statsScreen')
    </div>
    @if(@session('success'))
    <div class="row mb-3 mt-3">
        <div class="col-md-8 mx-auto">
            <div class="alert alert-success">{!! @session('success') !!}</div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <!-- sponsor list -->
                    @if(count($data['sponsorHistory']) == 0)
                        <div class="pt-5 pb-5">
                            <div class="has-background VR pt-5 pb-5">
                                <!--  -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 class="fa-2x text">We can&apos;t seem to find any sponsorship records</h1>
                                </div>
                            </div>
                        </div>
                    @else
                        <h2 class="h2-responsive text">Your Sponsorships</h2>
                        <?php $delay = 0.6; ?>
                        @foreach($data['sponsorHistory'] as $item)
                            @include('inc/sponsorListItem')
                            <?php $delay += 0.6; ?>
                        @endforeach
                    @endif
                </div>
                <div class="col-md-3 mx-auto">
                    <!-- more stats -->
                    <div class="row shadow mt-4 mb-5 pt-5">
                        <div class="col-12">
                            <div class="row">
                                <div class="mb-3 col-12 align-text-center pl-2 pr-2">
                                    <h1 class="fa-3x align-text-center text mb-0">{{ number_format(count($data['stats']['sponsor_list'])) }}</h1>
                                    <small class="grey-text">Sponsorships</small>
                                </div>
                                <div class="mt-3 mb-5 mb-3 col-12 align-text-center pl-2 pr-2">
                                    <h3 class="fa-2x align-text-center text mb-0">&#8358;{{ number_format($data['stats']['capital_all_time'], 2) }}</h3>
                                    <small class="grey-text">Total Capital</small>
                                </div>
                            </div>
                            <div class="row p-5 grass-blades"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- featured sponsorships -->
    @if(count($data['featured_sponsorships']) > 0)
    <div class="row p-3 p-md-5 pt-5 mb-0 grey lighten-5">
        <div class="col-12 mb-5">
            <h1 class="fa-2x text">Featured Sponsorships
                <small class="fs-14 float-right"><a href="/sponsorships">See More <span class="fa fa-arrow-right"></span></a></small>
            </h1>
        </div>
        <?php $delay = 0.6; ?>
        @foreach($data['featured_sponsorships'] as $item)
            @if($item->subcategory != null)
                @include('inc/itemCard')
                <?php $delay += 0.6; ?>
            @endif
        @endforeach
    </div>
    @endif
</div>
@endsection