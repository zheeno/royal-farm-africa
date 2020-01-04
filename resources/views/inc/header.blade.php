<nav class="mb-1 navbar navbar-expand-lg fixed-top navbar-light white shadow-none pt-md-0 pb-md-0">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('img/logo_no_text.png') }}" />
    </a>
    <button class="navbar-toggler" type="button" onClick='$("#navbarSupportedContent-4").collapse("toggle");' aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/login">
                    <i class="fas fa-gear"></i> Login</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item active">
                        <a class="nav-link waves-effect waves-light" href="/register">
                        Register
                        <span class="sr-only">(current)</span>
                        </a>
                    </li>
                @endif
            @else
            <li class="nav-item @if(Route::currentRouteName() == 'home' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/dashboard">
                Dashboard</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'history' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/history">
                History</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'charts' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/charts/BTC">
                Charts</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'security' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/security">
                Security</a>
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
