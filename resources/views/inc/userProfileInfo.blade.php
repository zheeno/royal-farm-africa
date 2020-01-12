<!-- user info -->
<div class="row pt-4">
    <div class="col-12 align-text-center">
        @if(Auth::user()->profile)
            @if(strlen(Auth::user()->profile->avatar_url) == 0)
            <img src="@if(Auth::user()->profile->gender == 'male'){{ asset('img/afro_male_avatar.png') }}@else {{ asset('img/afro_female_avatar.png') }}@endif" class="img-responsive avatar-rounded" />
            @else
            <!-- display profile image -->
            <img src="{{ Auth::user()->profile->avatar_url }}" class="img-responsive avatar-rounded" />
            @endif
        @else
            <img src="{{ asset('img/afro_male_avatar.png') }}" class="img-responsive avatar-rounded" />
        @endif
        <h4 class="h4-responsive text bold">{{ Auth::user()->name }}</h4>
        <span class="grey-text neg-mt-10">{{ Auth::user()->email }}</span>
    </div>
</div>