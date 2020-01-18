<?php use App\Http\Controllers\HomeController; ?>

<nav class="mb-1 navbar navbar-expand-lg navbar-light white shadow-none" style="margin-top: -13px;">
    <a class="navbar-brand  mr-4" href="/">
        <img src="{{ asset('img/logo.png') }}" />
    </a>
    <button class="navbar-toggler" type="button" onClick='$("#navbarSupportedContent-4").collapse("toggle");' aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item @if(Route::currentRouteName() == 'landing' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/">
                <span class="fa fa-home"></span>
                Home</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'sponsorships' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/sponsorships">
                <span class="fa fa-seedling"></span>
                Sponsorships</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item @if(Route::currentRouteName() == 'login' ) active @endif">
                    <a class="nav-link waves-effect waves-light" href="/login">
                    <i class="fas fa-gear"></i> Login</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item @if(Route::currentRouteName() == 'register' ) active @endif">
                        <a class="nav-link waves-effect waves-light" href="/register">
                        Register
                        <span class="sr-only">(current)</span>
                        </a>
                    </li>
                @endif
            @else
            <li class="nav-item @if(Route::currentRouteName() == 'home' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/dashboard">
                <span class="fa fa-dharmachakra"></span>
                Dashboard</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'history' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/history">
                <span class="fa fa-clock"></span>
                History</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'profile' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/profile">
                <span class="fa fa-user"></span>
                Profile</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'security' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/security">
                <span class="fa fa-shield-alt"></span>
                Security</a>
            </li>
            @if(Auth::user()->isAdmin())
            <li class="nav-item @if(Route::currentRouteName() == 'cms' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/cms">
                <span class="fa fa-code"></span>
                CMS</a>
            </li>
            @endif

            <li class="nav-item @if(Route::currentRouteName() == 'cart' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/cart">
                    <span class="hidden-sm fa fa-shopping-cart"></span>
                    <span class="hidden-md">Cart</span>
                    @if(count(HomeController::getCartData()['cart_items']) > 0)
                    &nbsp;
                    <span class="badge red lighten-1 p-2" style="border-radius: 50px">{{ count(HomeController::getCartData()['cart_items']) }}</span>
                    @endif  
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link waves-effect waves-light" data-toggle="modal" data-target="#logoutModal">
                <span class="hidden-sm fa fa-sign-out-alt"></span>
                <span class="hidden-md">Log out</span></a>
            </li>
            @endguest
        </ul>
    </div>
</nav>

<!-- logout modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content black-lighten-3">
      <div class="modal-header border-0">
        <h5 class="modal-title green-text" id="logoutModalLabel">Log out</h5>
        <button type="button" class="close p-3" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-ic fa fa-times"></span>
        </button>
      </div>
      <div class="modal-body align-text-center">
          <span class="fa fa-info-circle fa-2x white-ic mb-3"></span>
        <p class="lead align-text-center white-text">Do you really wish to log out?</p>
      </div>
      <div class="modal-footer border-0">
        <form id="logout-form" class="mx-auto" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="button" class="btn grey lighten-4" data-dismiss="modal"><span class="text">Cancel</span></button>
            <button type="submit" class="btn green-btn">Log out</button>
        </form>
      </div>
    </div>
  </div>
</div>
