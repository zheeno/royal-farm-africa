@extends('layouts.investor')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | Sponsorships</title>
@endsection

@section('content')
    <div class="container-fluid">
            @if(@session('error'))
            <div class="row mb-3">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-danger">
                        <span class="fa fa-check-circle"></span>
                        <span>{!! @session('error') !!}</span>
                    </div>
                </div>
            </div>
            @endif
        <div class="row grey lighten-3 p-3 mb-4">
            <div class="col-md-10 mx-auto mt-4 align-text-center">
                <a href="/sponsorships" class="@if($data['current_cat_id'] == 0)green-btn @else text shadow-none @endif btn mb-0 btn-sm ml-1 mr-1">All</a>
                @foreach($data['sub_cats'] as $subCat)
                <a href="/sponsorships?id={{ $subCat->id }}" class="@if($data['current_cat_id'] == $subCat->id)green-btn @else text shadow-none @endif btn mb-0 btn-sm ml-1 mr-1">{{ $subCat->sub_category_name }}</a>
                @endforeach
            </div>
        </div>
        @if(count($data['sponsorships']) > 0)
            <div class="row">
                <div class="col-12 p-3 align-text-center">
                    <h2 class="h2-responsive text bold">Sponsorships /
                    <span class="grey-text">
                    @if($data['current_cat_id'] == 0)
                        All
                    @else
                        {{ $data['cur_sub_category']->sub_category_name }}
                    @endif
                    </span>
                </div>
                <?php $delay = 0.6 ?>
                @foreach($data['sponsorships'] as $item)
                @if($item->subcategory != null)
                    @include('inc/itemCard')
                    <?php $delay += 0.6 ?>
                @endif
                @endforeach
            </div>
            <div class="row mt-3">
                <div class="col-10 mx-auto">
                    {{ $data['sponsorships']->links() }}
                </div>
            </div>
        @else
            <div class="row pt-5">
                <div class="col-12 has-background NORESULT"></div>
            </div>
        @endif

        @if($data['cur_sub_category'] != null)
        <div class="row p-3 pt-5 grey lighten-3 mt-5" style="min-height: 30vh">
            <div class="col-md-10 mx-auto">
                <h2 class="text h2-responsive bold">{{ $data['cur_sub_category']->sub_category_name }}</h2>
                <span class="text">{!! $data['cur_sub_category']->description !!}</span>
            </div>
        </div>
        @endif
    </div>
@endsection