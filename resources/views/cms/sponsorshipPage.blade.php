@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - Sponsorships - {{ $data['sponsorship']->title }}</title>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h3 class="h3-responsive mb-0"><a href="/cms">CMS</a> / <a href="/cms/sponsorships">Sponsorships</a> / <strong>{{ $data['sponsorship']->title }}</strong></h3>
                    <span class="badge badge-info"><span class="fa-2x">{{$data['sponsorship']->location->location_name}}</span></span>
                    <span class="badge badge-success"><span class="fa-2x">{{$data['sponsorship']->category->category_name}} - {{$data['sponsorship']->subcategory->sub_category_name}}</span></span>
                </div>
            </div>
            @if(@session('success'))
            <div class="row mb-3 mt-3">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-success">{!! @session('success') !!}</div>
                </div>
            </div>
            @endif
            @if(@session('error'))
            <div class="row mb-3 mt-3">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-danger">{!! @session('error') !!}</div>
                </div>
            </div>
            @endif
            <div class="navbar p-1 grey darken-1">
                <button class="btn btn-sm grey lighten-2" data-toggle="tooltip" title="Edit Sponsorship"><span class="fa fa-2x fa-edit"></span></button>
                <button class="btn btn-sm grey lighten-2" onClick="$('#manStatusModal').modal('show')" data-toggle="tooltip" title="Manage Sponsorship Status"><span class="fa fa-2x fa-toolbox"></span></button>
                <button class="btn btn-sm grey lighten-2" onClick="$('#sponListModal').modal('show')" data-toggle="tooltip" title="Sponsors"><span class="fa fa-2x fa-users"></span></button>
                <button class="btn btn-sm grey lighten-2" onClick="$('#sponPayoutModal').modal('show')" data-toggle="tooltip" title="Payouts"><span class="fa fa-2x fa-credit-card"></span></button>
            </div>
        </div>
    </div>
    <div class="row px-md-5 pb-5">
    
    </div>
<!-- Manage sponsorship status modal -->
<div class="modal fade top" id="manStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog  modal-md" role="document">
    <div class="modal-content">
        <form id="manStatusForm" action="/cms/sponsorships/update/status" method="POST">
            @csrf
            <input type="hidden" name="spon_id" value="{{$data['sponsorship']->id}}" required/>
          <div class="modal-body align-text-center p-0">
            <div class="m-5 p-5">
                <h3 class="h3-responsive text mt-3">Manage sponsorship status</h3>
                    <div class="container-fluid mb-5">
                        <!-- is active -->
                        <div class="row">
                            <div class="col pt-2">
                                <h5 class="h5-responsive">Is Active</h5>
                                <input type="hidden" name="is_active" id="is_active_val" value="{{$data['sponsorship']->is_active}}" required/>
                            </div>
                            <div class="col">
                                <button type="button" id="is_active_tog" data-state="{{$data['sponsorship']->is_active}}" class="spon-state-tog btn btn-sm shadow-none p-2 ">
                                    <span class="fa fa-3x @if($data['sponsorship']->is_active == 1) fa-toggle-on green-ic @else fa-toggle-off red-ic @endif"></span>
                                </button>
                            </div>
                        </div>
                        <!-- in progress -->
                        <div class="row">
                            <div class="col pt-2">
                                <h5 class="h5-responsive">In Progress</h5>
                                <input type="hidden" name="in_progress" id="in_progress_val" value="{{$data['sponsorship']->in_progress}}" required/>
                            </div>
                            <div class="col">
                                <button type="button" id="in_progress_tog" data-state="{{$data['sponsorship']->in_progress}}" class="spon-state-tog btn btn-sm shadow-none p-2 ">
                                    <span class="fa fa-3x @if($data['sponsorship']->in_progress == 1) fa-toggle-on green-ic @else fa-toggle-off red-ic @endif"></span>
                                </button>
                            </div>
                        </div>
                        <!-- is completed -->
                        <div class="row">
                            <div class="col pt-2">
                                <h5 class="h5-responsive">Is Completed</h5>
                                <input type="hidden" name="is_completed" id="is_completed_val" value="{{$data['sponsorship']->is_completed}}" required/>
                            </div>
                            <div class="col">
                                <button type="button" id="is_completed_tog" data-state="{{$data['sponsorship']->is_completed}}" class="spon-state-tog btn btn-sm shadow-none p-2 ">
                                    <span class="fa fa-3x @if($data['sponsorship']->is_completed == 1) fa-toggle-on green-ic @else fa-toggle-off red-ic @endif"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-block green darken-3" style="border-radius:0px !important"><span class="white-text">Save Status Changes</span></button>
          </div>
        </form>
      </div>
  </div>
</div>
<!-- Manage sponsorship status modal /-->

<!-- Display list of all sponsors modal -->
<div class="modal fade right" id="sponListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog top modal-md" role="document">
    <div id="sponsorsList" data-spon-id="{{$data['sponsorship']->id}}" class="modal-content">
        <!-- content will be loaded here with react -->
      </div>
  </div>
</div>
<!-- Display list of all sponsors modal /-->

<!-- Sponsorship payouts manager modal -->
<div class="modal fade right" id="sponPayoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog top modal-lg" role="document">
    <div id="sponsorshipPayouts" data-spon-id="{{$data['sponsorship']->id}}" class="modal-content">
        <!-- content will be loaded here with react -->
      </div>
  </div>
</div>
<!-- Sponsorship payouts manager modal /-->
@endsection
