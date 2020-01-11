<a data-toggle="tooltip" class="sponsor-list-item row @if($item->sponsorship->in_progress && !$item->sponsorship->is_completed) in-progress @elseif(!$item->sponsorship->in_progress && $item->sponsorship->is_completed) is-completed @else white @endif mb-2 shadow p-3 p-md-2 wow flipInX" data-wow-delay="{{ $delay ?? 0 }}s" data-wow-duration="4s" href="{{ $url ?? '/sponsors/'.$item->id }}" title="@if($item->sponsorship->in_progress && !$item->sponsorship->is_completed) Sponsorship in progress @elseif(!$item->sponsorship->in_progress && $item->sponsorship->is_completed) Sponsorship Completed @else Sponsorship awaiting commencement @endif">
    <div class="col-md-3">
        <strong class="text">{{ $item->sponsorship->title }}</strong>
        <br /><small class="grey-text" style="top:-10px; position: relative"><time class="timeago" datetime="{{ $item->created_at }}"></time></small>
    </div>
    <div class="col-md-2 align-text-center">
        <strong class="text">{{ $item->units }}</strong>
        <br /><small class="grey-text" style="top:-10px; position: relative">Units</small>
    </div>
    <div class="col-md-2 align-text-center">
        <strong class="text">{{ $item->expected_return_pct * 100 }}%</strong>
        <br /><small class="grey-text" style="top:-10px; position: relative">Return</small>
    </div>
    <div class="col-md-2 align-text-center">
        <strong class="text">&#8358;{{ number_format($item->total_capital, 2) }}</strong>
        <br /><small class="grey-text" style="top:-10px; position: relative">Capital</small>
    </div>
    @if(!$item->sponsorship->is_completed)
    <div class="col-md-3 align-text-center">
        <strong class="text">&#8358;{{ number_format($item->total_capital * $item->expected_return_pct, 2) }}</strong>
        <br /><small class="grey-text" style="top:-10px; position: relative"><time class="timeago" datetime="{{ $item->sponsorship->expected_completion_date }}"></time></small>
    </div>
    @else
    <div class="col-md-3 align-text-center">
        <strong class="text">&#8358;{{ number_format($item->actual_returns_received, 2) }}</strong>
        <br /><small class="grey-text" style="top:-10px; position: relative">Actual Returns</small>
    </div>
    @endif
</a>