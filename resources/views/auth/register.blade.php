@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row pt-5 pb-5 mb-5">
        <div class="col-12">
            <h1 class="fa-3x mb-5 text">Register</h1>
        </div>
        <div class="col-md-5 white shadow-lg mb-5 wow flipInY" data-wow-delay="1s" data-wow-duration="5s">
            <div class="card shadow-none">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="md-form">
                            <label for="name" class="grey-text">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form">
                            <label for="email" class="grey-text">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form">
                            <label for="password" class="grey-text">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form">
                            <label for="password-confirm" class="grey-text">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="row">
                            <div class="col-md-1"><input id="checkbox" type="checkbox" required /></div>
                            <div class="col-md-10">
                                <label for="checkbox" class="grey-text" style="font-size:14px">
                                    I agree to the {{ env("APP_NAME") }} Terms of Use
                                    </label>
                            </div>
                        </div>
                        <div class="md-form">
                            <button type="submit" class="btn btn-md w-100 green-btn block">
                                Create Account
                            </button>
                        </div>
                        <div class="m-3 align-text-center">
                            <small>Already registered? <a class="green-text" href="/login">Login</a></small></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7 register-right">
            <!--  -->
        </div>
    </div>
</div>
@endsection
