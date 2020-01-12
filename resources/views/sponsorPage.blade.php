@extends('layouts.investor')
<?php use App\Http\Controllers\HomeController; ?>
@section('title')
<title>{{ config('app.name', 'Laravel') }} | Sponsor - {{ $data['sponsor']->sponsorship->title }}</title>
@endsection

@section('content')
    <div class="container white">
        <div class="row shadow-lg mb-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 grey has-background" style="background-size:cover;background-image:url({{ $data['sponsor']->sponsorship->subcategory->cover_image_url }})">
                        @if($data['sponsor']->sponsorship->subcategory->video_url != null)
                            <a class="video-link-btn smoothScroll btn red ml-2 pt-2 pb-2 pl-3 pr-3" href="#videoPlayer"><span class="fa fa-video white-ic"></span></a>
                        @endif
                    </div>
                </div>
                <div class="row p-3 pl-md-5 pr-md-5">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="h1-responsive text mb-0">{{ $data['sponsor']->sponsorship->title }}</h1>
                                <a href="/sponsorships/locations/{{ $data['sponsor']->sponsorship->location->id }}" class="badge badge-info white-text">{{ $data['sponsor']->sponsorship->location->location_name }}</a>
                                <span class="badge" data-toggle="tooltip" title="{{ $data['sponsor']->sponsorship->created_at }}"><span class="text">Entry created 
                                    <time class="timeago" datetime="{{ $data['sponsor']->created_at }}"></time>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-md-3 mx-auto pt-2">
                                <h5 class="h5-responsive mb-0 text">{{ $data['sponsor']->sponsorship->expected_returns_pct * 100 }}%</h5>
                                <small class="neg-mt-10 grey-text">Return</small>
                            </div>
                            <div class="col-5 col-md-3 mx-auto pt-2">
                                <h5 class="h5-responsive mb-0 text">{{ number_format($data['sponsor']->sponsorship->duration_in_months) }}&nbsp;<small>months</small></h5>
                                <small class="neg-mt-10 grey-text">Duration</small>
                            </div>
                            @if(!$data['sponsor']->sponsorship->is_completed)
                            <div class="col-md-3 mx-auto pt-2">
                                @if($data['remSponsUnits'] > 0 && $data['sponsor']->sponsorship->is_active)
                                    <h5 class="h5-responsive mb-0 text">{{ number_format($data['remSponsUnits']) }}</h5>
                                    <small class="neg-mt-10 grey-text">Avail. Units</small>
                                @else
                                    <span class="badge badge-danger">Sold Out</span>
                                @endif
                            </div>
                            @endif
                            <div class="col-md-3 mx-auto pt-2">
                                @if($data['sponsor']->sponsorship->in_progress)
                                    <span class="badge badge-info">In Progress</span>
                                @else
                                    @if($data['sponsor']->sponsorship->is_completed)
                                    <span class="badge badge-success">Completed</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12 align-text-right">
                                <h3 class="h3-responsive green-text mb-0 align-text-right bold">&#8358;{{ number_format($data['sponsor']->sponsorship->price_per_unit, 2) }}</h3>
                                <span class="grey-text">Price per Unit</span>
                            </div>
                            <div class="col-12 align-text-right">
                                <div>
                                    <button class="btn bg-green btn-sm-rounded float-right">
                                        <span class="white-text">{{ HomeController::getInitials("Fruitful Farms") }}</span>
                                    </button>&nbsp;
                                    <strong class="float-right">Fruitful Farms</strong>
                                    <br />
                                    <a data-toggle="tooltip" title="Category" href="/sponsorships?id={{ $data['sponsor']->sponsorship->subcategory->id }}" class="badge badge-success float-right">{{ $data['sponsor']->sponsorship->subcategory->sub_category_name }}</a>
                                </div>
                            </div>
                                <div class="col-12 align-text-right">
                                    @if(!$data['sponsor']->sponsorship->is_completed)
                                    <span class="badge orange darken-2" data-toggle="tooltip" title="{{ $data['sponsor']->sponsorship->expected_completion_date }}">
                                        <span class="white-ic fa-clock fa"></span>&nbsp;
                                        <span class="white-text">Maturity Period:</span>&nbsp;
                                        <time class="white-text timeago" datetime="{{ $data['sponsor']->sponsorship->expected_completion_date }}"></time>
                                    </span>
                                    @else
                                    <span class="badge green darken-2">
                                        <span class="white-ic fa-clock fa"></span>&nbsp;
                                        <span class="white-text">Matured:</span>&nbsp;
                                        <time class="white-text timeago" datetime="{{ $data['sponsor']->sponsorship->actual_completion_date }}"></time>
                                    </span>
                                    @endif
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- description -->
        <div class="row mt-5 mb-5">
            <div class="col-md-10 mx-auto p-4 p-md-4">
                <p class="text lead">{!! $data['sponsor']->sponsorship->description !!}</p>
            </div>
        </div>
        <!-- user's investments -->
        @if($data['sponsor']->user_id == Auth::user()->id)
        <div class="row mt-2 mb-5">
            <div class="col-md-10 mx-auto shadow-lg wow flipInX" data-wow-delay="0.6s" data-wow-duration="5s">
                <h5 class="h5-responsive text bold ml-3 mt-3">Your Investment</h5>
                <div class="row">
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                        <h2 class="h2-responsive text">{{ number_format($data['sponsor']->units) }}</h2>
                        <span class="fs-14 neg-mt-10 grey-text">Units Sponsored by You</span>
                    </div>
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                        <h2 class="h2-responsive text">&#8358;{{ number_format($data['sponsor']->total_capital, 2) }}</h2>
                        <span class="fs-14 neg-mt-10 grey-text">Capital Invested</span>
                    </div>
                    @if(!$data['sponsor']->sponsorship->is_completed)
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                        <h2 class="h2-responsive green-text bold">&#8358;{{ number_format($data['sponsor']->total_capital * $data['sponsor']->expected_return_pct, 2) }}</h2>
                        <span class="fs-14 neg-mt-10 grey-text">Estimated Profit</span>
                    </div>
                    @else
                    <div class="col-md-4 p-3 align-text-center">
                        <div class="row mb-3">
                            <div class="col-12 pt-2">
                                <h4 class="h4-responsive green-text bold">&#8358;{{ number_format(($data['sponsor']->actual_returns_received - $data['sponsor']->total_capital), 2) }}</h4>
                                <span class="fs-14 neg-mt-10 grey-text">Profit Made</span>
                            </div>
                            <div class="col-12">
                                <h4 class="h4-responsive green-text bold">&#8358;{{ number_format($data['sponsor']->actual_returns_received, 2) }}</h4>
                                <span class="fs-14 neg-mt-10 grey-text">Actual Returns Received</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row p-5 grass-blades"></div>
            </div>
        </div>
        @endif
        <!-- engagement -->
        <div class="row mt-2 mb-5">
            <div class="col-md-10 mx-auto p-3 p-md-4 wow fadeIn" data-wow-delay="0.9s" data-wow-duration="5s">
                <h5 class="h5-responsive text bold ml-3">Engagement</h5>
                <div class="row">
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                        <h2 class="h2-responsive text bold"><span class="counter" data-count-to='{{ $data["claimed_units"] }}'>{{ $data['claimed_units'] }}</span>&nbsp;<small class="grey-text">/&nbsp;{{ $data['sponsor']->sponsorship->total_units }}</small></h2>
                        <span class="fs-14 neg-mt-10 grey-text">Units Sponsored</span>
                    </div>
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center border-left border-right">
                        <h2 class="h2-responsive text">{{ number_format(count($data['other_sponsors'])) }}</h2>
                        <span class="fs-14 neg-mt-10 grey-text">Sponsors</span>
                    </div>
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                        <h2 class="h2-responsive green-text bold">&#8358;{{ number_format($data['cap_raised'], 2) }}</h2>
                        <span class="fs-14 neg-mt-10 grey-text">Capital Raised</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- reviews and rating -->
        @if(count($data['sponsor']->sponsorship->reviews) > 0)
        <div class="row mb-5 mt-3 p-3">
            <div class="col-md-7 mx-auto pt-2 pb-2">
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
                @if(Auth::user()->id == $data['sponsor']->user_id)
                        @include('inc/reviewForm')
                @endif
            </div>
        </div>
        <div class="row mt-2 mb-3">
            <div class="col-12">
                <h3 class="h3-responsive text bold">Reviews</h3>
            </div>
            @foreach($data['sponsor']->sponsorship->reviews as $index => $review)
            <div class="col-md-5 p-3 p-md-4 shadow-lg mb-3 @if($index % 2) ml-auto @else mr-auto @endif">
                <div class="row">
                    <div class="col-12 border-bottom">
                        @if($review->author->profile)
                            @if(strlen($review->author->profile->avatar_url) == 0)
                            <button class="btn bg-green btn-sm-rounded float-left">
                                <span class="white-text">{{ HomeController::getInitials($review->author->name) }}</span>
                            </button>
                            @else
                            <img src="{{ $review->author->profile->avatar_url }}" class="img-responsive btn-sm-rounded" />
                            @endif
                        @else
                            <button class="btn bg-green btn-sm-rounded float-left">
                                <span class="white-text">{{ HomeController::getInitials($review->author->name) }}</span>
                            </button>
                        @endif
                        &nbsp;
                        <strong class="text">{{ $review->author->name }}</strong>
                        @if($review->is_author_sponsor)<br /><small class="neg-mt-10 ml-2 grey-text">Sponsor</small>@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-3">
                        <p class="text">{{ $review->review }}</p>
                    </div>
                </div>
                <div class="row review-footer">
                    <div class="col-md-6">
                        <small class="grey-text">
                            <time class="timeago" datetime="{{ $review->created_at }}"></time>
                        </small>
                    </div>
                    <div class="col-md-5 align-text-right">
                        {!! HomeController::showStars($review->num_stars) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="row p-3 p-md-5">
                <div class="col-md-7 mr-auto has-background NOREV"></div>
                <div class="col-md-5 ml-auto">
                    <h3 class="text fa-2x">Oops, there are reviews here.<br />Be the first to drop a review</h3>
                    @if(Auth::user()->id == $data['sponsor']->user_id)
                        @include('inc/reviewForm')
                    @endif
                </div>
            </div>
        @endif
        <!-- video player -->
        @if($data['sponsor']->sponsorship->subcategory->video_url != null)
        <div id="videoPlayer" class="row">
            @if($data['sponsor']->sponsorship->subcategory->video_tag_line != null)
            <div class="col-12 pl-4 pl-md-5">
                <h2 class="h2-responsive mb-md-0 bold text">{{ $data['sponsor']->sponsorship->subcategory->video_tag_line }}</h2>
            </div>
            @endif
            <div class="col-12 m-md-4 mt-0 shadow-lg p-0 black-lighten-3">
                <iframe class="video-container" src="{{ $data['sponsor']->sponsorship->subcategory->video_url }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        @endif
    </div>
@endsection