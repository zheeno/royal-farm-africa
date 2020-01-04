@extends('layouts.investor')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('inc/statsScreen')
    </div>
    <!-- featured sponsorships -->
    @if(count($data['sponsorships']) > 0)
    <div class="row p-3 p-md-5 pt-5 pb-5 grey lighten-5">
        <div class="col-12 mb-5">
            <h1 class="fa-2x text">Featured Sponsorships</h1>
        </div>
        <?php $delay = 0.6; ?>
        @foreach($data['sponsorships'] as $item)
            @include('inc/itemCard')
            <?php $delay += 0.6; ?>
        @endforeach
    </div>
    @endif
</div>
@endsection
