@extends('layouts.adminator')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS</title>
@endsection

@section('content')
<div class="container">
    <div class="row pt-5">
        <div class="white col-md-3 mx-auto mb-md-3 shadow py-4 px-2 align-text-right" style="border-bottom: 5px solid #457">
            <h3 class="h3-responsive mb-0 align-text-right">{{ number_format($data['user_count']) }}</h3>
            <small class="grey-text">Users</small>
        </div>
        <!-- <div class="white col-md-2 mx-auto mb-md-3 shadow py-4 px-2 align-text-right" style="border-bottom: 5px solid #4caf50">
            <h3 class="h3-responsive mb-0 align-text-right">2,000</h3>
            <small class="grey-text">Farmers</small>
        </div> -->
        <div class="white col-md-3 mx-auto mb-md-3 shadow py-4 px-2 align-text-right" style="border-bottom: 5px solid #1976d2">
            <h3 class="h3-responsive mb-0 align-text-right">{{ number_format($data['ongoing_sponsorships_counter']) }}</h3>
            <small class="grey-text">Ongoing Sponsorships</small>
        </div>
        <div class="white col-md-3 mx-auto mb-md-3 shadow py-4 px-2 align-text-right" style="border-bottom: 5px solid #009688">
            <h3 class="h3-responsive mb-0 align-text-right">{{ number_format($data['sponsors_counter']) }}</h3>
            <small class="grey-text">Sponsors</small>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-12">
                    <h5 class="text h5-responsive">Recent Transctions</h5>
                    @if(count($data['transactions']) == 0)
                    <div class="py-3 px-4 shadow-lg white">
                        <div class="has-background NOTRANSACT pt-3 pb-3"></div>
                        <div class="w-100 align-text-center pt-4 pb-5">
                            <h5 class="h5-responsive grey-text">No transactions found</h5>
                        </div>
                    </div>
                    @else
                        @foreach($data['transactions'] as $key => $transaction)
                            <div class="row mb-0 shadow-lg ml-1 mr-1 pl-3 pr-3 pt-2 border-bottom white" id="{{ 'transact_'.$key }}">
                                <div class="col-12 p-0 overflow-x-hidden">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="h5-responsive mb-0 @if(!$transaction->is_credit) green-text bold @else red-text @endif">@if($transaction->is_credit){{'-'}}@endif&#8358;{{ number_format($transaction->amount ,2) }}</h5>
                                            <small class="grey-text neg-mt-10" data-toggle="tooltip" title="{{$transaction->created_at}}">{{$transaction->created_at}}<time class="timeago" datetime="{{$transaction->created_at}}"></time></small>
                                        </div>
                                        <div class="col-12">
                                            <span class="neg-mt-10 bold">{{$transaction->user->name}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 pl-3 mx-auto">
            <div class="row">
                <div class="col-12">
                    <h5 class="text h5-responsive">Engagements</h5>
                </div>  
                <div class="col-12 shadow-lg white">
                    <div class="row p-2 p-md-4 my-3">
                        <div class="col-md-4 p-3 align-text-center">
                            <h2 class="h2-responsive text mb-0 align-text-center">{{ number_format($data['sponsorship_rate'], 2) }}%</h2>
                            <span class="fs-14 grey-text">Sponsorship Rate</span>
                        </div>
                        <div class="col-md-7 ml-auto p-3 align-text-center">
                            <h2 class="h2-responsive text mb-0 align-text-center">&#8358;{{ number_format($data['capital_raised'], 2) }}</h2>
                            <span class="fs-14 grey-text">Total Capital Raised</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
