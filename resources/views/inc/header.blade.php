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
            <li class="nav-item @if(Route::currentRouteName() == 'dashboard' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/dashboard">
                Dashboard</a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() == 'wallet' ) active @endif">
                <a class="nav-link waves-effect waves-light" href="/wallet">
                Wallet</a>
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