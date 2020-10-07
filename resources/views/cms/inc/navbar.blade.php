<!-- ### $Topbar ### -->
<div class="header navbar">
    <div class="header-container">
        <ul class="nav-left">
        <li>
            <a id='sidebar-toggle' class="sidebar-toggle" href="javascript:void(0);">
            <i class="ti-menu"></i>
            </a>
        </li>
        </ul>
        <ul class="nav-right">
        <li class="dropdown">
            <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
            <div class="peer mR-10">
                @if(Auth::user()->profile)
                    @if(strlen(Auth::user()->profile->avatar_url) == 0)
                    <button class="btn bg-green btn-sm-rounded float-left">
                        <span class="white-text">{{ HomeController::getInitials(Auth::user()->name) }}</span>
                    </button>
                    @else
                    <img src="{{ Auth::user()->profile->avatar_url }}" class="w-2r bdrs-50p img-responsive btn-sm-rounded" />
                    @endif
                @else
                    <button class="btn bg-green btn-sm-rounded float-left">
                        <span class="white-text">{{ HomeController::getInitials(Auth::user()->name) }}</span>
                    </button>
                @endif
                <!-- <img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt=""> -->
            </div>
            <div class="peer">
                <span class="fsz-sm c-grey-900">{{ Auth::user()->name }}</span>
            </div>
            </a>
        </li>
        </ul>
    </div>
</div>