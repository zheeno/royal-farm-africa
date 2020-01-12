<?php use App\Http\Controllers\HomeController; ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="row">
            <div class="p-0 col-2 align-text-center">
                @if(Auth::user()->profile)
                    @if(strlen(Auth::user()->profile->avatar_url) == 0)
                    <button class="btn bg-green btn-sm-rounded float-left">
                        <span class="white-text">{{ HomeController::getInitials(Auth::user()->name) }}</span>
                    </button>
                    @else
                    <img src="{{ Auth::user()->profile->avatar_url }}" class="img-responsive btn-sm-rounded" />
                    @endif
                @else
                    <button class="btn bg-green btn-sm-rounded float-left">
                        <span class="white-text">{{ HomeController::getInitials(Auth::user()->name) }}</span>
                    </button>
                @endif
            </div>
            <div class="p-0 col-8">
                <strong class="text">{{ Auth::user()->name }}</strong>
                <br /><span class="fs-14 neg-mt-10 grey-text">Sponsor</span>
            </div>
        </div>
        <form method="POST" action="/sponsorships/addReview">
            @csrf
            <div class="md-form m-0">
                <span class="grey-text">Rating</span>
                <input type="hidden" name="sponsor_id" value="{{ $data['sponsor']->id }}" />
                <input type="hidden" name="sponsorship_id" value="{{ $data['sponsor']->sponsorship_id }}" />
                <input id="rating" type="hidden" name="rating" value="5" />
                <button id="ratingButton" class="btn p-2 pl-0 align-text-left m-0 btn-block shadow-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fa fa-star yellow-ic"></span>
                    <span class="fa fa-star yellow-ic"></span>
                    <span class="fa fa-star yellow-ic"></span>
                    <span class="fa fa-star yellow-ic"></span>
                    <span class="fa fa-star yellow-ic"></span>
                </button>
                <div class="dropdown-menu p-0" id="ratingSelector">
                    @for($i = 1; $i < 6; $i++)
                    <a class="dropdown-item border-0 p-0 pl-2" data-value="{{ $i }}" data-toggle="tooltip" title="@if($i > 1) {{ $i.' stars' }} @else {{ $i.' star' }} @endif ">
                        {!! HomeController::showStars($i) !!}
                    </a>
                    @endfor
                </div>
            </div>
            <div class="md-form m-0 p-0">
                <span class="grey-text" for="review">Review</span>
                <textarea id="review" name="review" class="w-100 m-0 p-0 pt-2 md-textarea" placeholder="Tell us what you think"></textarea>
            </div>
            <button type="submit" class="btn green-btn">Add Review</button>
        </form>
    </div>
</div>