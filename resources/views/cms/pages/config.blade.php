@extends('layouts.adminator')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | Config</title>
@endsection

@section('content')
<form method="POST" action="">
@csrf
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="h3-responsive"><a href="/cms">CMS</a> / <strong>Configuration</strong></h3>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="float-right btn btn-sm btn-dark deep-purple darken-4"><span class="fa fa-save"></span> Save &amp; Publish</button>
                </div>
            </div>
            <div class="alert alert-info">
                <span class="fa fa-star"></span>
                <span>Here you can modify some of the platform's settings.</span>
            </div>
            @if(@session('success'))
                <div class="alert alert-success">
                    <span class="fa fa-check-circle"></span>
                    <span>{!! @session('success') !!}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="row pb-5">
        <!-- contact info setup -->
        <div class="col-md-5 white mx-auto shadow-sm p-3 px-4">
            <div class="navbar grey lighten-4">
                <h4 class="h4-responsive">Contact Information</h4>
            </div>
            <div class="row mt-4">
                <div class="col-md-5 white mx-auto md-form mb-5">
                    <label>Primary Phone No.</label>
                    <input type="text" name="phone_1" value="{{ $data['config'] ? $data['config']->contact_phone_1 : null }}" class="form-control" />
                </div>
                <div class="col-md-5 white mx-auto md-form mb-5">
                    <label>Secondary Phone No.</label>
                    <input type="text" name="phone_2" value="{{ $data['config'] ? $data['config']->contact_phone_2 : null }}" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 white mx-auto md-form mb-5">
                    <label>Primary E-mail Address</label>
                    <input type="text" name="contact_email_1" value="{{ $data['config'] ? $data['config']->contact_email_1 : null }}" class="form-control" />
                </div>
                <div class="col-md-5 white mx-auto md-form mb-5">
                    <label>Secondary E-mail Addresss</label>
                    <input type="text" name="contact_email_2" value="{{ $data['config'] ? $data['config']->contact_email_2 : null }}" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 white mx-auto md-form mb-5">
                    <label>Head Office Address</label>
                    <input type="text" name="contact_address_1" value="{{ $data['config'] ? $data['config']->contact_address_1 : null }}" class="form-control" />
                </div>
                <div class="col-md-5 white mx-auto md-form mb-5">
                    <label>Branch Office Address</label>
                    <input type="text" name="contact_address_2" value="{{ $data['config'] ? $data['config']->contact_address_2 : null }}" class="form-control" />
                </div>
            </div>
        </div>

        <!-- Privacy Policy setup -->
        <div class="col-md-6 white mx-auto shadow-sm p-3 px-4">
            <div class="navbar grey lighten-4">
                <h4 class="h4-responsive">Privacy Policy</h4>
            </div>
            <div class="md-form">
                <textarea name="privacy_policy" style="min-height: 300px" class="md-textarea w-100 tinyMiceEditor">{{ $data['config'] ? $data['config']->privacy_policy : null }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-11 white mx-auto shadow-sm p-3 px-4">
            <div class="navbar grey lighten-4">
                <h4 class="h4-responsive">Terms of Use</h4>
            </div>
            <div class="md-form">
                <textarea name="terms_of_use" style="min-height: 300px" class="md-textarea w-100 tinyMiceEditor">{{ $data['config'] ? $data['config']->terms_of_use : null }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 white mx-auto shadow-sm p-3 px-4">
            <div class="navbar grey lighten-4">
                <h4 class="h4-responsive">Terms of Sponsorship</h4>
            </div>
            <div class="md-form">
                <textarea name="terms_of_sponsorship" style="min-height: 300px" class="md-textarea w-100 tinyMiceEditor">{{ $data['config'] ? $data['config']->terms_of_sponsorship : null }}</textarea>
            </div>
        </div>
        <div class="col-md-5 white mx-auto shadow-sm p-3 px-4">
            <div class="navbar grey lighten-4">
                <h4 class="h4-responsive">Terms of Farm Visit</h4>
            </div>
            <div class="md-form">
                <textarea name="terms_of_farm_visit" style="min-height: 300px" class="md-textarea w-100 tinyMiceEditor">{{ $data['config'] ? $data['config']->terms_of_farm_visit : null }}</textarea>
            </div>
        </div>

        <div class="col-md-4 mt-5 mx-auto align-text-center">
            <button type="submit" class="btn btn-sm btn-dark deep-purple darken-4"><span class="fa fa-save"></span> Save &amp; Publish</button>
        </div>
    </div>
</div>
</form>
@endsection
