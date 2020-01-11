@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Cart</title>
@endsection

@section('content')
<div class="container-fluid p-5 white">
    @if(count($data['cart_items']) == 0)
        <div class="row pt-5">
            <div class="col-12 has-background NORESULT"></div>
            <div class="col-12 align-text-center">
                <h3 class="h3-responsive text">Your cart is empty</h3>
            </div>
        </div>
    @else
    <div class="row p-md-5">
        <div class="col-md-7 pt-3 mr-auto">
            <h3 class="h3-responsive text bold">Your Cart items</h3>
            <?php $delay = 0.6; ?>
            @foreach($data['cart_items'] as $item)
            <div class="row">
                <div class="col-md-11">
                    <?php $url = '/sponsorships/'.$item->sponsorship->id ?>
                    @include('inc/sponsorListItem')
                </div>
                <div class="col-md-1 wow flipInX" data-wow-delay="{{ $delay }}s" data-wow-duration="5s">
                    <form method="POST" action="/cart/remove">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}" />
                        <button type="submit" class="btn btn-sm btn-white shadow-none p-2 ml-0 mr-0 mt-3 mb-3"><span class="fa fa-times red-ic"></span>&nbsp;<span class="red-text">Remove</span></button>
                    </form>
                </div>
            </div>
                <?php $delay += 0.6; ?>
            @endforeach
        </div>
        <div class="col-md-4 ml-auto white shadow-sm pt-3 pb-5">
            <h3 class="h3-responsive text bold">Summary</h3>
            <div class="pr-3 pl-md-3 align-text-right">
                <h3 class="h3-responsive bold text mb-0">{{ number_format($data['total_units']) }}</h3>
                <span class="fs-14 grey-text neg-mt-10">Units Sponsored</span>
            </div>
            <div class="pr-3 pl-md-3 align-text-right">
                <h3 class="h3-responsive bold text mb-0">&#8358;{{ number_format($data['total_est_returns'], 2) }}</h3>
                <span class="fs-14 grey-text neg-mt-10">Total Expected Returns</span>
            </div>
            <div class="pr-3 pl-md-3 align-text-right">
                <h2 class="green-text mb-0">&#8358;{{ number_format($data['total_cap'], 2) }}</h2>
                <span class="s-14 grey-text neg-mt-10">Total Capital</span>
            </div>
            <div class="align-text-center">
                <form method="POST" action="/cart/checkout">
                    @csrf
                    <button class="btn green-btn" type="submit">Checkout</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection