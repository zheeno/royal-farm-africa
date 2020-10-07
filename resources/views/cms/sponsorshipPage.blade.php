@extends('layouts.adminator')
@section('title')
<?php use App\Http\Controllers\HomeController; 
 $sponsorship_id = $data['sponsorship']->id ?>

<title>{{ config('app.name', 'Laravel') }} | CMS - Sponsorships - {{ $data['sponsorship']->title }}</title>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h3 class="h3-responsive mb-0"><a href="/cms">CMS</a> / <a href="/cms/sponsorships">Sponsorships</a> / <strong>{{ $data['sponsorship']->title }}</strong></h3>
                    <span class="badge badge-info" data-toggle="tooltip" title="Location"><span class="fa-2x">{{$data['sponsorship']->location->location_name}}</span></span>
                    <span class="badge badge-success" data-toggle="tooltip" title="Category - Subcategory"><span class="fa-2x">{{$data['sponsorship']->category->category_name}} - {{$data['sponsorship']->subcategory->sub_category_name}}</span></span>
                    <span class="badge pink darken-2" data-toggle="tooltip" title="Duration"><span class="fa-2x">{{$data['sponsorship']->duration_in_months}} months</span></span>
                    <span class="badge cyan darken-2" data-toggle="tooltip" title="Price per unit"><span class="fa-2x">&#8358;{{number_format($data['sponsorship']->price_per_unit, 2)}}</span></span>
                    <span class="badge red darken-2" data-toggle="tooltip" title="Returns per unit"><span class="fa-2x">{{ number_format($data['sponsorship']->expected_returns_pct * 100, 1) }}%</span></span>
                </div>
            </div>
            @if(@session('success'))
            <div class="row mb-3 mt-3">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-success">{!! @session('success') !!}</div>
                </div>
            </div>
            @endif
            @if(@session('error'))
            <div class="row mb-3 mt-3">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-danger">{!! @session('error') !!}</div>
                </div>
            </div>
            @endif
            <div class="navbar p-1 grey darken-1">
                <button class="btn btn-sm grey lighten-2" data-toggle="tooltip" title="Edit Sponsorship"><span class="fa fa-2x fa-edit"></span></button>
                <button class="btn btn-sm grey lighten-2" onClick="$('#manStatusModal').modal('show')" data-toggle="tooltip" title="Manage Sponsorship Status"><span class="fa fa-2x fa-cog"></span></button>
                <button class="btn btn-sm grey lighten-2" onClick="$('#sponListModal').modal('show')" data-toggle="tooltip" title="Sponsors"><span class="fa fa-2x fa-users"></span></button>
                <button class="btn btn-sm grey lighten-2" onClick="$('#sponPayoutModal').modal('show')" data-toggle="tooltip" title="Payouts"><span class="fa fa-2x fa-credit-card"></span></button>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-md-10 mx-auto p-4 p-md-4">
            <p class="text lead">{!! $data['sponsorship']->description !!}</p>
        </div>
    </div>
    <div class="row pb-5">
        <!-- engagement -->
        <div class="col-md-10 mx-auto my-5 shadow-lg white p-3  p-md-4 wow fadeIn" data-wow-delay="0.9s" data-wow-duration="5s">
            <h5 class="h5-responsive text bold ml-3">Engagement</h5>
            <div class="row py-4">
                <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                    <h2 class="h2-responsive text bold"><span class="counter" data-count-to='{{ $data["claimed_units"] }}'>{{ $data['claimed_units'] }}</span>&nbsp;<small class="grey-text">/&nbsp;{{ $data['sponsorship']->total_units }}</small></h2>
                    <span class="fs-14 neg-mt-10 grey-text">Units Sponsored</span>
                </div>
                <div class="col-md-4 p-3 pt-5 pb-5 align-text-center border-left border-right">
                    <h2 class="h2-responsive text">{{ number_format(count($data['other_sponsors'])) }}</h2>
                    <span class="fs-14 neg-mt-10 grey-text">Sponsors</span>
                </div>
                <div class="col-md-4 p-3 pt-5 pb-5 ">
                    <div class="row">
                        <div class="col-12 align-text-center">
                            <h4 class="h4-responsive green-text bold">&#8358;{{ number_format($data['cap_raised'], 2) }}</h4>
                            <span class="fs-14 neg-mt-10 grey-text">Capital Raised</span>
                        </div>
                    </div>
                    @if($data['sponsorship']->is_completed)
                    <div class="row">
                        <div class="col-12 align-text-center">
                            <h3 class="h3-responsive green-text bold">&#8358;{{ number_format($data['total_payouts'], 2) }}</h3>
                            <span class="fs-14 neg-mt-10 grey-text">Total Payouts</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- engagement /-->
    </div>
    <!-- reviews and rating -->
    @if(count($data['sponsorship']->reviews) > 0)
    <div class="row mb-5 mt-3 p-3">
        <div class="col-md-6 mx-auto pt-2 pb-2">
            <h3 class="text h3-responsive bold">Rating</h3>
            <div class="row">
                <div class="col-md-5 align-text-center pt-3 pb-3">
                    <h1 class="fa-4x text bold align-text-center">{{ number_format($data['ratings']['rating'],1) }}</h1>
                </div>
                <div class="col-md-5">
                    @for($i = 1; $i <= 5; $i++)
                        <div class="row">
                            <div class="col-8">{!! HomeController::showStars($i) !!}</div>
                            <div class="col-4 align-text-right">
                                {{ $data['ratings'][$i.'_stars'] }}
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="col-md-5 mx-auto pt-2 pb-2">
            <h3 class="text h3-responsive bold ml-3">Add your review</h3>
            @if(Auth::user()->isAdmin())
                @include('inc/reviewForm')
            @endif
        </div>
    </div>
    <div class="row mt-2 mb-3 p-5 shadow-lg white">
        <div class="col-12 mb-5 mt-5">
            <h3 class="h3-responsive text bold">Reviews</h3>
        </div>
        @foreach($data['sponsorship']->reviews as $index => $review)
        <div class="col-md-5 p-3 p-md-4 mb-3 mx-auto shadow-sm">
            <div class="row">
                <div class="col-12 grey lighten-4">
                    <div class="row">
                        <div class="col-2 align-text-center">
                        @if($review->author->profile)
                            @if(strlen($review->author->profile->avatar_url) == 0)
                            <button class="btn bg-green btn-sm-rounded">
                                <span class="white-text">{{ HomeController::getInitials($review->author->name) }}</span>
                            </button>
                            @else
                            <img src="{{ $review->author->profile->avatar_url }}" class="img-responsive btn-sm-rounded" />
                            @endif
                        @else
                            <button class="btn bg-green btn-sm-rounded">
                                <span class="white-text">{{ HomeController::getInitials($review->author->name) }}</span>
                            </button>
                        @endif
                        </div>
                        <div class="col-10">
                            <strong class="text">{{ $review->author->name }}</strong>
                            <div class="row">
                                @if($review->is_author_sponsor)
                                <div class="col">
                                    @if($review->author->isAdmin())
                                        <span class="badge badge-warning neg-mt-10">ADMIN</span>
                                    @else
                                        <span class="badge badge-info neg-mt-10">SPONSOR</span>
                                    @endif
                                </div>
                                @endif
                                <div class="col align-text-right ml-auto pr-5"><span class="neg-mt-10">{!! HomeController::showStars($review->num_stars) !!}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-3 px-md-3">
                    <p class="text mx-3">{!! $review->review !!}</p>
                </div>
            </div>
            <div class="row review-footer">
                <div class="col-12 align-text-right my-2">
                    <small class="grey-text">
                        <time class="timeago" datetime="{{ $review->created_at }}">{{ $review->created_at }}</time>
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    <!-- reviews and rating /-->
    </div>
    @else
        <div class="row p-3 p-md-5">
            <div class="col-md-7 mr-auto has-background NOREV"></div>
            <div class="col-md-5 ml-auto">
                <h3 class="text fa-2x">Oops, there are no reviews here.<br />Be the first to drop a review</h3>
                @if(Auth::user()->isAdmin())
                    @include('inc/reviewForm')
                @endif
            </div>
        </div>
    @endif







<!-- Manage sponsorship status modal -->
<div class="modal fade top" id="manStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog  modal-md" role="document">
    <div class="modal-content">
        <form id="manStatusForm" action="/cms/sponsorships/update/status" method="POST">
            @csrf
            <input type="hidden" name="spon_id" value="{{$data['sponsorship']->id}}" required/>
          <div class="modal-body align-text-center p-0">
            <div class="m-5 p-5">
                <h3 class="h3-responsive text mt-3">Manage sponsorship status</h3>
                    <div class="container-fluid mb-5">
                        <!-- is active -->
                        <div class="row">
                            <div class="col pt-2">
                                <h5 class="h5-responsive">Is Active</h5>
                                <input type="hidden" name="is_active" id="is_active_val" value="{{$data['sponsorship']->is_active}}" required/>
                            </div>
                            <div class="col">
                                <button type="button" id="is_active_tog" data-state="{{$data['sponsorship']->is_active}}" class="spon-state-tog btn btn-sm shadow-none p-2 ">
                                    <span class="fa fa-3x @if($data['sponsorship']->is_active == 1) fa-toggle-on green-ic @else fa-toggle-off red-ic @endif"></span>
                                </button>
                            </div>
                        </div>
                        <!-- in progress -->
                        <div class="row">
                            <div class="col pt-2">
                                <h5 class="h5-responsive">In Progress</h5>
                                <input type="hidden" name="in_progress" id="in_progress_val" value="{{$data['sponsorship']->in_progress}}" required/>
                            </div>
                            <div class="col">
                                <button type="button" id="in_progress_tog" data-state="{{$data['sponsorship']->in_progress}}" class="spon-state-tog btn btn-sm shadow-none p-2 ">
                                    <span class="fa fa-3x @if($data['sponsorship']->in_progress == 1) fa-toggle-on green-ic @else fa-toggle-off red-ic @endif"></span>
                                </button>
                            </div>
                        </div>
                        <!-- is completed -->
                        <div class="row">
                            <div class="col pt-2">
                                <h5 class="h5-responsive">Is Completed</h5>
                                <input type="hidden" name="is_completed" id="is_completed_val" value="{{$data['sponsorship']->is_completed}}" required/>
                            </div>
                            <div class="col">
                                <button type="button" id="is_completed_tog" data-state="{{$data['sponsorship']->is_completed}}" class="spon-state-tog btn btn-sm shadow-none p-2 ">
                                    <span class="fa fa-3x @if($data['sponsorship']->is_completed == 1) fa-toggle-on green-ic @else fa-toggle-off red-ic @endif"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-block green darken-3" style="border-radius:0px !important"><span class="white-text">Save Status Changes</span></button>
          </div>
        </form>
      </div>
  </div>
</div>
<!-- Manage sponsorship status modal /-->

<!-- Display list of all sponsors modal -->
<div class="modal fade right" id="sponListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog top modal-md" role="document">
    <div id="sponsorsList" data-spon-id="{{$data['sponsorship']->id}}" class="modal-content">
        <!-- content will be loaded here with react -->
      </div>
  </div>
</div>
<!-- Display list of all sponsors modal /-->

<!-- Sponsorship payouts manager modal -->
<div class="modal fade right" id="sponPayoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog top modal-lg" role="document">
    <div id="sponsorshipPayouts" data-spon-id="{{$data['sponsorship']->id}}" class="modal-content">
        <!-- content will be loaded here with react -->
      </div>
  </div>
</div>
<!-- Sponsorship payouts manager modal /-->
@endsection
