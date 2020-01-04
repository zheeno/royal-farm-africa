@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Sponsor History</title>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('inc/statsScreen')
    </div>
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
                        @foreach($data['sponsorHistory'] as $history)
                            <a class="row white mb-2 shadow p-3 p-md-2 wow flipInX" data-wow-delay="{{ $delay }}s" data-wow-duration="4s" href="/sponsors/{{ $history->id }}">
                                <div class="col-md-3">
                                    <strong class="text">{{ $history->sponsorship->title }}</strong>
                                    <br /><small class="grey-text" style="top:-10px; position: relative"><time class="timeago" datetime="{{ $history->created_at }}"></time></small>
                                </div>
                                <div class="col-md-2 align-text-center">
                                    <strong class="text">{{ $history->units }}</strong>
                                    <br /><small class="grey-text" style="top:-10px; position: relative">Units</small>
                                </div>
                                <div class="col-md-2 align-text-center">
                                    <strong class="text">{{ $history->expected_return_pct * 100 }}%</strong>
                                    <br /><small class="grey-text" style="top:-10px; position: relative">Return</small>
                                </div>
                                <div class="col-md-2 align-text-center">
                                    <strong class="text">&#8358;{{ number_format($history->total_capital, 2) }}</strong>
                                    <br /><small class="grey-text" style="top:-10px; position: relative">Capital</small>
                                </div>
                                <div class="col-md-3 align-text-center">
                                    <strong class="text">&#8358;{{ number_format($history->total_capital * $history->expected_return_pct, 2) }}</strong>
                                    <br /><small class="grey-text" style="top:-10px; position: relative"><time class="timeago" datetime="{{ $history->sponsorship->expected_completion_date }}"></time></small>
                                </div>
                            </a>
                            <?php $delay += 0.6; ?>
                        @endforeach
                    @endif
                </div>
                <div class="col-md-3 mx-auto">
                    <!-- account stats -->
                    
                    <div class="row shadow pb-5 bg-green"> 
                        <div class="col-12 p-3">
                            <h5 class="h5-responsive white-text bold">Your Wallet</h5> 
                        </div>
                        <div class="mt-3 mb-3 col-12 align-text-center pl-2 pr-2">
                            <h3 class="fa-2x align-text-center white-text mb-0">&#8358;{{ number_format($data['stats']['capital_all_time'] - $data['stats']['active_expected_returns'], 2) }}</h3>
                            <small class="white-text">Avail. Balance</small>
                        </div>
                        <div class="mt-3 mb-3 col-12 align-text-center pl-2 pr-2">
                            <h3 class="fa-2x align-text-center white-text mb-0">&#8358;{{ number_format($data['stats']['capital_all_time'], 2) }}</h3>
                            <small class="white-text">Ledger Balance</small>
                        </div>
                    </div>
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
            <h1 class="fa-2x text">Featured Sponsorships</h1>
        </div>
        <?php $delay = 0.6; ?>
        @foreach($data['featured_sponsorships'] as $item)
            @include('inc/itemCard')
            <?php $delay += 0.6; ?>
        @endforeach
    </div>
    @endif
</div>
@endsection