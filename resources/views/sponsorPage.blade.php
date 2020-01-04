@extends('layouts.investor')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | Sponsor - {{ $data['sponsor']->sponsorship->title }}</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row shadow-lg mb-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 grey has-background" style="background-size:cover;background-image:url({{ $data['sponsor']->sponsorship->subcategory->cover_image_url }})"></div>
                </div>
                <div class="row p-3 pl-md-5 pr-md-5">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="h1-responsive text mb-0">{{ $data['sponsor']->sponsorship->title }}
                                    @if($data['sponsor']->sponsorship->subcategory->video_url != null)
                                    <a class="smoothScroll btn btn-sm red ml-2 pt-2 pb-2 pl-3 pr-3" href="#videoPlayer"><span class="fa fa-video white-ic"></span></a>
                                    @endif
                                </h1>
                                <a href="/sponsorships/locations/{{ $data['sponsor']->sponsorship->location->id }}" class="badge badge-info white-text">{{ $data['sponsor']->sponsorship->location->location_name }}</a>
                                <span class="badge"><span class="text">Entry created 
                                    <time class="timeago" datetime="{{ $data['sponsor']->sponsorship->created_at }}"></time>
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
                            <div class="col-md-3 mx-auto pt-2">
                                @if($data['remSponsUnits'] > 0 && $data['sponsor']->sponsorship->is_active)
                                    <h5 class="h5-responsive mb-0 text">{{ number_format($data['remSponsUnits']) }}</h5>
                                    <small class="neg-mt-10 grey-text">Avail. Units</small>
                                @else
                                    <span class="badge badge-danger">Sold Out</span>
                                @endif
                            </div>
                            <div class="col-md-3 mx-auto pt-2">
                                @if($data['sponsor']->sponsorship->in_progress)
                                    <span class="badge badge-warning">In Progress</span>
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
                                        <span class="white-text">F</span>
                                    </button>&nbsp;
                                    <strong class="float-right">Fruitful Farms</strong>
                                    <br />
                                    <a href="/sponsorships/category/{{ $data['sponsor']->sponsorship->category->id }}/{{ $data['sponsor']->sponsorship->subcategory->id }}" class="badge badge-success float-right">{{ $data['sponsor']->sponsorship->subcategory->sub_category_name }}</a>
                                </div>
                            </div>
                                <div class="col-12 align-text-right">
                                    @if(!$data['sponsor']->sponsorship->is_completed)
                                    <span class="badge orange darken-2">
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
                    <div class="col-md-4 p-3 pt-5 pb-5 align-text-center">
                        <h2 class="h2-responsive green-text bold">&#8358;{{ number_format($data['sponsor']->total_capital * $data['sponsor']->expected_return_pct, 2) }}</h2>
                        <span class="fs-14 neg-mt-10 grey-text">Estimated Profit</span>
                    </div>
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
                        <h2 class="h2-responsive text">{{ $data['claimed_units'] }}&nbsp;<small class="grey-text">/&nbsp;{{ $data['sponsor']->sponsorship->total_units }}</small></h2>
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
        <!-- video player -->
        @if($data['sponsor']->sponsorship->subcategory->video_url != null)
        <div id="videoPlayer" class="row">
            @if($data['sponsor']->sponsorship->subcategory->video_tag_line != null)
            <div class="col-12 pl-5 pb-1">
                <h2 class="h2-responsive bold text">{{ $data['sponsor']->sponsorship->subcategory->video_tag_line }}</h2>
            </div>
            @endif
            <div class="col-12 black-lighten-3">
                <iframe class="video-container" src="{{ $data['sponsor']->sponsorship->subcategory->video_url }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        @endif
    </div>
@endsection