@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row pt-5 pb-5 mb-5">
        <div class="col-12">
            <h1 class="fa-3x mb-5 text">Log In</h1>
        </div>
        <div class="col-md-5 mx-auto mb-5 white shadow-lg wow flipInY" data-wow-delay="1s" data-wow-duration="5s">
            <div class="card shadow-none">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="md-form" style="margin-top:50px !important">
                            <label for="email" class="grey-text">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form" style="margin-top:50px !important">
                            <label for="password" class="grey-text">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div style="display:none">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>

                        <div class="row mb-0">
                            <div class="col-12 mx-auto">
                                <button type="submit" class="btn green-btn block w-100">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <div class="col-md-6 mt-5" style="font-size: 14px">
                                @if (Route::has('password.request'))
                                    <a class="green-text" href="{{ route('password.request') }}">
                                        Forgot Password
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-6 mt-5" style="font-size: 14px">
                                @if (Route::has('register'))
                                    Not a member? <a class="green-text" href="{{ route('register') }}">
                                        Register
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7 login-right">
            <!--  -->
        </div>
    </div>
</div>
@endsection
