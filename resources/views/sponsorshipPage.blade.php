@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Sponsorship - {{ $data['sponsorship']->title }}</title>
@endsection
@section('content')
    <div class="container pl-md-5 pr-md-5">
        <div class="row">
            <div class="col-10 mx-auto white mx-auto shadow-lg mt-5 mb-3">
                <div class="row">
                    <div class="col-md-4 p-0">
                        <div class="lg-card-img-container p-5 white" style="background-size:cover !important;background-image:url({{ $data['sponsorship']->subcategory->cover_image_url }});">
                            <!--  -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="p-3">
                            <div class="row border-bottom pb-2">
                                <div class="col-6">
                                    <strong class="text">{{ $data['sponsorship']->title }}</strong>
                                    <br /><small class="fs-14 grey-text" style="top: -10px !important; position: relative;">{{ $data['sponsorship']->location->location_name }}</small>
                                </div>
                                <div class="col-6 align-text-right">
                                    <span class="green-text bold">&#8358; {{ number_format($data['sponsorship']->price_per_unit, 2) }}</span>
                                    <br /><small class="grey-text">Per Unit</small>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-3">
                                    <small class="grey-text">Return</small>
                                    <br /><strong class="text">{{ $data['sponsorship']->expected_returns_pct * 100 }}%</strong>
                                </div>
                                <div class="col-4 align-text-right">
                                    <small class="grey-text">Duration</small>
                                    <br /><span class="text">{{ $data['sponsorship']->duration_in_months }} @if($data['sponsorship']->duration_in_months > 1) {{"months"}} @else {{"month"}} @endif</span>
                                </div>
                                <div class="col-4 align-text-right">
                                    @if($data['sponsorship']->total_units - $data['sponsored_units'] > 0 && $data['sponsorship']->is_active )
                                    <small class="grey-text">Available Units</small>
                                    <br />
                                    <span class="text">{{ number_format($data['sponsorship']->total_units - $data['sponsored_units']) }}</span>
                                    @else
                                    <span class="mt-4 badge badge-danger">Sold Out</span>
                                    @endif
                                </div>
                            </div>
                            @if($data['sponsorship']->total_units > $data['sponsored_units'] && $data['sponsorship']->is_active == true)
                                <form method="POST" action="/sponsors/addToCart">
                                    @csrf
                                    <input type="hidden" name="sponsorship_id" value="{{ $data['sponsorship']->id }}" />
                                    <div class="row pt-3">
                                        <div class="col-md-5 mx-auto">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <button type="button" class="dec-unit btn btn-grey btn-sm m-0">-</span>
                                                </div>
                                                <input id="units" type="number" name="selected_units" value="@if($data['cart_item']){{$data['cart_item']->units}}@else{{1}}@endif" data-max-val="{{ number_format($data['sponsorship']->total_units - $data['sponsored_units']) }}" class="p-0 align-text-center form-control" required />
                                                <div class="input-group-append">
                                                    <button type="button" class="inc-unit btn btn-grey btn-sm m-0">+</span>
                                                </div>
                                            </div>
                                            @if($data['cart_item'])
                                                <span class="neg-mt-10 red-text">Sponsorship added to cart</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mx-auto align-text-right">
                                            <button type="submit" class="btn green-btn">Sponsor</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            @if(@session('error'))
                            <div class="alert alert-danger p-2 small">{{ @session('error')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- data -->
        <div class="row">
            <div class="col-10 mx-auto white p-3 mx-auto shadow-lg mb-3">
            <div class="row">
                    <div class="col-md-6">
                    <small class="fs-14 grey-text">Category</small>
                    <h2 class="text h2-responsive">{{ $data['sponsorship']->category->category_name }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- description  -->
        <div class="row">
            <div class="col-10 mx-auto white p-3 p-md-5 mx-auto shadow-lg mb-5 text">
                {!! $data['sponsorship']->description !!}
            </div>
        </div>

        <!-- video player -->
        @if($data['sponsorship']->subcategory->video_url != null)
        <div id="videoPlayer" class="row">
            @if($data['sponsorship']->subcategory->video_tag_line != null)
            <div class="col-12 pl-4 pl-md-5">
                <h2 class="h2-responsive mb-md-0 bold text">{{ $data['sponsorship']->subcategory->video_tag_line }}</h2>
            </div>
            @endif
            <div class="col-12 m-md-4 mt-0 shadow-lg p-0 black-lighten-3">
                <iframe class="video-container" src="{{ $data['sponsorship']->subcategory->video_url }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        @endif
    </div>
@endsection