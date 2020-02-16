@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - Homepage Setup</title>
@endsection
@section('content')
<form id="homeSetForm" data-req-pass="2359" class="container" method="POST" action="/cms/home">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="h3-responsive"><a href="/cms">CMS</a> / <strong>Homepage Setup</strong></h3>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="float-right btn btn-sm btn-dark deep-purple darken-4"><span class="fa fa-save"></span> Save &amp; Publish</button>
                    <a href="/" target="_blank" class="float-right btn btn-sm btn-white grey lighten-3"><span class="fa fa-eye"></span> Preview</a>
                </div>
            </div>
            <div class="alert alert-info">
                <span class="fa fa-star"></span>
                <span>Here you can modify the content of the Home page on the website.</span>
            </div>
            @if(@session('success'))
                <div class="alert alert-success">
                    <span class="fa fa-check-circle"></span>
                    <span>{!! @session('success') !!}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="row px-md-5 pb-5">
        <!-- title -->
        <div class="col-12 mx-2 shadow-lg white pt-3 pb-3">
            @include('cms/inc/title')
        </div>
        <!-- hero image section -->
        <div class="col-12 mx-2 mt-3 shadow-lg white pt-3 pb-3">
            @include('cms/inc/hero')
        </div>
        <!-- Core values -->
        <div class="col-12 mx-2 mt-3 shadow-lg white pt-3 pb-3">
            @include('cms/inc/values')
        </div>
        <!-- Featured values -->
        <div class="col-12 mx-2 mt-3 shadow-lg white pt-3 pb-3">
            @include('cms/inc/featured')
        </div>
        <!-- Misc Section -->
        <div class="col-12 mx-2 mt-3 shadow-lg white pt-3 pb-3">
            @include('cms/inc/misc')
        </div>
    </div>
</form>
@endsection
