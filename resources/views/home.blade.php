@extends('layouts.investor')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
@endsection
<?php use App\Http\Controllers\HomeController; ?>
@section('content')
<div class="container-fluid">
    <!-- notify user if profile has not been setup -->
    @if(!Auth::user()->profile)
    <div class="alert alert-info align-text-center">
        <span>Your Profile has not been setup. </span> To have access to all of our features, kindly click <strong><a href="/profile">here</a></strong> to complete your profile.
    </div>
    @endif
        @include('inc/userProfileInfo')
    <!-- statistics -->
    <div class="row mt-3">
        @include('inc/statsScreen')
    </div>
    <!-- transactions and account balance -->
    <div class="row">
        <div class="col-md-5 ml-auto border-right">
            <div class="row mt-3">
                <div class="col-md-6">
                    <h3 class="text h3-responsive ml-2 mb-0">Wallet Transactions</h3>
                </div>
                <div class="col-md-6 align-text-right">
                    <h5 class="mr-2 text h5-responsive mb-0 green-text bold">&#8358;{{ number_format(HomeController::getWalletBalance(), 2) }}</h5>
                    <small class="mr-2 grey-text neg-mt-10">Wallet Balance</small><br />
                    <button type="button" onClick="$('#addFundCol').collapse('toggle');$('#mainTranCol').collapse('toggle')" class="btn btn-sm green-btn m-0 neg-mt-10">Add Funds</button>
                </div>
            </div>
            <div class="collapse" id="addFundCol">
                <form method="POST" action="/ravePay">
                    @csrf
                    <h4 class="h4-responsive text bold">Add funds</h4>
                    <div class="alert alert-info">Fund your wallet using our secure payment platform.
                        Kindly note that {{ env('APP_NAME') }} will never store your card details. Your
                        privacy is really important to us and we take it seriously.
                    </div>
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="md-form">
                                <label>Amount (&#8358;)</label>
                                <input type="number" name="amount" class="form-control" required />
                            </div>
                            <div class="w-100 align-text-center p-3">
                                <input type="hidden" name="redirect" value="{{ env('APP_URL') }}/ravePay/handler" required />
                                <input type="hidden" name="desc" value="Wallet funding by user" required />
                                <button type="submit" class="btn green-btn">Proceed</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="collapse show" id="mainTranCol">
                @if(count(Auth::user()->transactions) == 0)
                    <div class="has-background NOTRANSACT pt-3 pb-3"></div>
                    <div class="w-100 align-text-center pt-4 pb-5">
                        <h5 class="h5-responsive grey-text">No transactions found</h5>
                    </div>
                @else
                    @foreach(Auth::user()->transactions as $key => $transaction)
                        <div class="row mb-2 ml-1 mr-1 shadow-sm pl-3 pr-3 pt-2 border-bottom white" id="{{ 'transact_'.$key }}">
                            <div class="col-12 p-0 overflow-x-hidden">
                                <h5 class="h5-responsive mb-0 @if($transaction->is_credit) green-text bold @else red-text @endif">@if(!$transaction->is_credit){{'-'}}@endif&#8358;{{ number_format($transaction->amount ,2) }}</h5>
                                <small class="grey-text neg-mt-10" data-toggle="tooltip" title="{{$transaction->created_at}}"><time class="timeago" datetime="{{$transaction->created_at}}"></time></small>
                                <p class="text neg-mt-10 m-0 fs-14">{!! $transaction->description !!}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-5 mr-auto">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="h3-responsive ml-2 mt-3">
                        <span class="blue-grey-ic fa fa-bell @if(count(Auth::user()->unreadNotifs) > 0) animated shake infinite @endif"></span>
                        @if(count(Auth::user()->unreadNotifs) > 0)
                        <span class="badge badge-danger notif-counter">{{ number_format(count(Auth::user()->unreadNotifs)) }}</span>
                        @endif
                    </h3>
                </div>
                @if(count(Auth::user()->allNotifs) > 0)
                <div class="col-md-4 align-text-right pt-4">
                    <a class="fs-12 bold blue-text notifColTog" data-pri-target="#allNotifsCol" data-sec-target="#unreadNotifsCol">All</a>
                    <span class="text">|</span>
                    <a class="fs-12 bold disabled border p-2 blue white-text notifColTog" data-pri-target="#unreadNotifsCol" data-sec-target="#allNotifsCol">Unread</a>
                </div>
                @endif
            </div>
            <!-- unread notifs -->
            <div id="unreadNotifsCol" class="collapse show">
                @if(count(Auth::user()->unreadNotifs) == 0)
                    <div class="has-background NONOTIFS pt-3 pb-3"></div>
                    <div class="w-100 align-text-center pt-4 pb-5">
                        <h5 class="h5-responsive grey-text">You have no unread notifications</h5>
                    </div>
                @else
                    @foreach(Auth::user()->unreadNotifs as $key => $notif)
                    <?php HomeController::markAsRead($notif->id) ?>
                        <div class="row mb-2 ml-1 mr-1 pl-3 pr-3 pt-2 border-bottom white" id="{{ 'notif_'.$key }}">
                            <div class="col-12 p-0 overflow-x-hidden">
                                <p class="text m-0 fs-14">{!! $notif->message !!}</p>
                                <small class="grey-text" data-toggle="tooltip" title="{{$notif->created_at}}"><time class="timeago" datetime="{{$notif->created_at}}"></time></small>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- all notifs -->
            <div id="allNotifsCol" class="collapse">
                @if(count(Auth::user()->allNotifs) == 0)
                    <div class="has-background NONOTIFS pt-3 pb-3"></div>
                    <div class="w-100 align-text-center pt-4 pb-5">
                        <h5 class="h5-responsive grey-text">You have no notifications</h5>
                    </div>
                @else
                    @foreach(Auth::user()->allNotifs as $key => $notif)
                    <?php HomeController::markAsRead($notif->id) ?>
                        <div class="row mb-2 ml-1 mr-1 pl-3 pr-3 pt-2 border-bottom white" id="{{ 'notif_'.$key }}">
                            <div class="col-12 p-0 overflow-x-hidden">
                                <p class="text m-0 fs-14">{!! $notif->message !!}</p>
                                <small class="grey-text" data-toggle="tooltip" title="{{$notif->created_at}}"><time class="timeago" datetime="{{$notif->created_at}}"></time></small>
                                @if($notif->seen)
                                <small class="float-right grey-text">Read</small>
                                @else
                                <span class="float-right badge badge-danger">NEW</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
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
