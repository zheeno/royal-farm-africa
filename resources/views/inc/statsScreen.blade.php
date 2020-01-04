@if(count($data["stats"]["sponsor_list"]) == 0)
    <div class="col-11 mx-auto mb-3 p-5 border-bottom">
        <div class="row">
            <div class="col-md-6 mr-auto E232"></div>
            <div class="col-md-5 p-md-5 pt-5 pb-5 ml-auto">
                <h1 class="text fa-2x">Looks like you do not have any investments</h1>
            </div>
        </div>
    </div>
@else
    <!-- display stats -->
    <div class="col-10 mx-auto p-5 shadow-lg mb-5">
        <div class="row">
            <!-- active sponsorships -->
            <div class="border-right col-md-3 pl-0 pr-0 pt-3 pb-3 align-text-center">
                <h1 class="text h1-responsive mb-0"><span class="counter" data-count-to='{{ $data["stats"]["active_sponsorships"] }}'>{{ number_format($data["stats"]["active_sponsorships"]) }}</span><small class="grey-text">&nbsp;/&nbsp;{{ number_format($data["stats"]["num_entries"]) }}</small></h1>
                <small class="grey-text">Active Sponsorships</small>
            </div>
            <!-- units of active sponsorships -->
            <div class="border-right mx-auto col-md-4">
                <div class="row">
                    <div class="col-12 border-bottom pl-0 pr-0 pt-1 pb-1 align-text-center">
                        <h3 class="text h3-responsive mb-0">{{ number_format($data["stats"]["total_active_units"]) }}</h3>
                        <small class="grey-text">Active Units</small>
                    </div>
                    <div class="col-12 pl-0 pr-0 pt-1 pb-1 align-text-center">
                        <h3 class="text h3-responsive mb-0">&#8358;<span>{{ number_format($data["stats"]["capital_active_units"], 2) }}</span></h3>
                        <small class="grey-text">Capital</small>
                    </div>
                </div>
            </div>
            <!-- monetary figures -->
            <div class="ml-auto col-md-4 pl-0 pr-0">
                <div class="row">
                    <div class="col-12 border-bottom pt-1 pb-1 align-text-center">
                        <h3 class="text h3-responsive mb-0">&#8358;{{ number_format($data["stats"]["active_expected_returns"], 2) }}</h3>
                        <small class="grey-text">Expected Returns in <time class="timeago" datetime="{{ $data['stats']['high_exp_comp_dates'] }}"></time></small>
                    </div>
                    <div class="col-12 pt-1 pb-1 align-text-center">
                        <h3 class="text h3-responsive mb-0">&#8358;{{ number_format($data["stats"]["total_profits_made"], 2) }}</h3>
                        <small class="grey-text">All-Time Profits</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif