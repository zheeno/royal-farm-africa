@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Checkout</title>
@endsection
<?php use App\Http\Controllers\HomeController; ?>
@section('content')
<div class="container-fluid p-5 white">
    <div class="row p-md-5">
        <div class="col-md-5 p-2 checkout has-background"></div>
        <div class="col-md-7 p-md-2">
            <h1 class="fa-3x text bold mt-3 mt-md-0">Checkout</h1>
            <h5 class="h5-responsive text">Kindly choose a payment option</h5>

            <form method="POST" action="/ravePay/checkout">
                @csrf
                <div class="row">
                    <a class="wallet-pay-btn col-md-5 mx-auto shadow-lg mt-4 pt-3 pb-3 bg-green @if(HomeController::getWalletBalance() < $data['total_cap']) disabled @endif" style="border-radius:5px">
                        <div class="row">
                            <div class="col-12 align-text-center">
                                <h3 class="h3-responsive white-text mb-0 align-text-center">Pay</h3>
                                <h5 class="h5-responsive white-text bold align-text-center">&#8358;{{ number_format($data['total_cap'], 2) }}</h5>
                                <span class="white-text">Using your virtual Wallet</span>
                                <br /><small class="white-text">Wallet Balance: &#8358;{{ number_format(HomeController::getWalletBalance(), 2) }}</small>
                            </div>
                        </div>
                    </a>
                    <div class="col-md-2 mx-auto pt-md-5 align-text-center mt-4"><span class="text bold">OR</span></div>
                    <button type="submit" class="col-md-5 mx-auto shadow-lg mt-4 pt-3 pb-3 bg-midnight-blue" style="border-radius:5px">
                        <div class="row">
                            <div class="col-12 align-text-center">
                                <h3 class="h3-responsive white-text mb-0 align-text-center">Pay Securely with</h3>
                                <img src="{{ asset('img/woosh/Flutterwave-678x381.png') }}" class="img-responsive mt-3" style="width:200px" />
                            </div>
                        </div>
                    </button>
                </div>
            </form>
            <div class="row">
                <div class="col-12 pt-3">
                    <span class="fs-14 grey-text">By choosing to pay you agree with {{env("APP_NAME")}}&apos;s terms of services.
                </div>
                @if(@session('error'))
                    <div class="col-12 alert alert-danger">{!! @session('error') !!}</div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- confirmation modal -->
@if(HomeController::getWalletBalance() >= $data['total_cap'])
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content black-lighten-3">
      <div class="modal-header border-0">
        <h3 class="h3-responsive modal-title bold orange-text" id="logoutModalLabel">Pay using wallet</h3>
        <button type="button" class="close p-3" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-ic fa fa-times"></span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="h5-responsive" style="color: #e0e0e0">
            Hello {{ Auth::user()->name }},<br /><br />
            You will be charged the sum of 
            <strong>&#8358;{{ number_format($data['total_cap']) }}</strong>
            from your virtual wallet. To proceed, kindly input your password 
            below and authorize the transaction.
        </h5>
        <form method="POST" action="/cart/checkout/wallet">
            @csrf
            <div class="md-form">
                <label for="pwd" style="color: #e0e0e0">Enter your Password</label>
                <input type="password" class="form-control white-text" id="pwd" name="acc_pwd" required />
            </div>
            <div class="align-text-center">
                <button type="submit" class="btn green-btn">Authorize</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endif

@endsection