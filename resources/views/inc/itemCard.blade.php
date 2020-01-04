<?php
    $sponsoredUnits = 0;
    foreach ($item->sponsors as $sponsor) {
        $sponsoredUnits += $sponsor->units;
    }
?>
<a href="/sponsorships/{{$item->id}}" class="col-md-3 p-0 mx-auto shadow wow fadeInRight" data-wow-delay="{{ $delay }}s" data-wow-duration="4s">
    <div class="card-img-container p-5 white" style="background-image:url('{{ $item->subcategory->cover_image_url }}')"></div>
    <div class="p-3">
        <div class="row">
            <div class="col-6">
                <strong class="text">{{ $item->title }}</strong>
                <br /><small class="fs-14 grey-text" style="top: -10px !important; position: relative;">{{ $item->location->location_name }}</small>
            </div>
            <div class="col-6 align-text-right">
                <span class="green-text">&#8358; {{ number_format($item->price_per_unit, 2) }}</span>
                <br /><small class="grey-text" style="top: -5px !important; position: relative;">Per Unit</small>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <small class="grey-text">Return</small>
                <br /><strong class="text">{{ $item->expected_returns_pct * 100 }}%</strong>
            </div>
            <div class="col-4 align-text-right">
                <small class="grey-text">Duration</small>
                <br /><span class="text">{{ $item->duration_in_months }} @if($item->duration_in_months > 1) {{"months"}} @else {{"month"}} @endif</span>
            </div>
            <div class="col-4 align-text-right pt-3">
                @if($item->total_units > $sponsoredUnits && $item->is_active == true)
                <span class="badge badge-success">Available</span>
                @else
                <span class="badge badge-danger">Sold Out</span>
                @endif
            </div>
        </div>
    </div>
</a>