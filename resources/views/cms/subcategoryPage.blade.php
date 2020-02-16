<?php use App\Http\Controllers\CMSController; 
    $subCatData = CMSController::getSubCatSponsorshipData($data['sub_category']->id);
?>
@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - Category - {{$data['category']->category_name}} - {{$data['sub_category']->sub_category_name}}</title>
@endsection
@section('content')
    <div class="container-fluid">        
        <div class="row mt-5">
            @if(@session('success'))
                <div class="col-10 mx-auto mb-5">
                    <div class="alert alert-success">
                        <span class="fa fa-check-circle"></span>
                        <span>{!! @session('success') !!}</span>
                    </div>
                </div>
            @endif
            @if(@session('error'))
                <div class="col-10 mx-auto mb-5">
                    <div class="alert alert-danger">
                        <span class="fa fa-check-circle"></span>
                        <span>{!! @session('error') !!}</span>
                    </div>
                </div>
            @endif
            <div class="col-12 p-0 white shadow-lg">
                <div class="jumbotron card shadow-none card-image p-0 hero-2 mb-0 border-0" style="background-image:url({{$data['sub_category']->cover_image_url}})">
                    <div class="mask py-md-5 px-md-5">
                        <div class="row text-white py-5 px-4 my-5">
                        <!--  -->
                        </div>
                    </div>
                </div>
                <div class="row mx-4 mb-2">
                    <div class="col-md-5 mr-auto p-3">
                        <h1 class="fa-2x bold mb-0 text mb-0 mt-0 wow fadeIn" data-wow-delay="0.6s"  data-wow-duration="5s">{{$data['sub_category']->sub_category_name}}@if($data['sub_category']->trashed())&nbsp;<small class="red-text">(Trashed)</small>@endif</h1>
                        @if(strlen($data['sub_category']->tag_line) > 0)<h5 class="fa-2x bold mb-0 text wow fadeIn" data-wow-delay="0.6s"  data-wow-duration="5s">{{$data['sub_category']->tag_line}}</h5>@endif
                        <a class="badge badge-info neg-mt-10" href="/cms/categories/{{$data['category']->id}}">{{$data['category']->category_name}}</a>
                    </div>
                    <div class="col-md-6 ml-auto p-3 align-text-right">
                        @if(!$data['sub_category']->trashed())
                        <button class="btn btn-sm grey lighten-2 shadow-none mx-0" data-toggle="tooltip" title="Edit subcategory" onClick="$('#editSubModal').modal('show')"><span class="fa fa-edit"></span></button>
                        <button class="btn btn-sm grey lighten-2 shadow-none mx-0" data-toggle="tooltip" title="Delete this subcategory" onClick="$('#delSubCatModal').modal('show')"><span class="fa fa-trash"></span></button>
                        <button class="btn btn-sm grey lighten-2 shadow-none mx-0" data-toggle="tooltip" title="Create a new sponsorship" onClick="$('#newSponModal').modal('show')"><span class="fa fa-plus"></span></button>
                        @else
                        <button class="btn btn-sm grey lighten-2 shadow-none mx-0" data-toggle="tooltip" title="Restore subcategory" onClick="$('#resSubCatModal').modal('show')"><span class="fa fa-refresh"></span></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- description and stats -->
        <div class="row mt-3">
            <div class="col-md-6">
                <h4 class="h4-responsive bold text">Description</h4>
                {!! $data['sub_category']->description !!}
            </div>
            <div class="col-md-6">
                <h4 class="h4-responsive bold text">Statistics</h4>
                <div class="row white shadow m-3 py-4">
                    <div class="col-md-5 mx-auto align-text-center">
                        <h2 class="text fa-2x mb-0">{{ number_format(count($data['sub_category']->sponsorships)) }}</h2>
                        <span class="grey-text">Sponsorships</span>
                    </div>
                    <div class="col-md-5 mx-auto align-text-center">
                        <h2 class="text fa-2x mb-0">{{ number_format($subCatData['total_units']) }}</h2>
                        <span class="grey-text">Units Sponsored</span>
                    </div>
                    <div class="col-md-11 mx-auto align-text-center">
                        <h2 class="text fa-2x mb-0">&#8358;{{ number_format($subCatData['total_capital'], 2) }}</h2>
                        <span class="grey-text">Capital Raised</span>
                    </div>
                    <div class="col-md-4 mx-auto align-text-center">
                        <h2 class="text fa-2x mb-0">{!! number_format($subCatData['active_sponsorships_count'])." <small class='grey-text'>/ ".number_format($subCatData['total_sponsorships_count'])."</small>" !!}</h2>
                        <span class="grey-text">Active Sponsorships</span>
                    </div>
                    <div class="col-md-7 mx-auto align-text-center">
                        <h2 class="text fa-2x mb-0">&#8358;{{ number_format($subCatData['total_returns'], 2) }}</h2>
                        <span class="grey-text">Total Payout</span>
                    </div>
                </div>
            </div>
        </div>
        @if(!$data['sub_category']->trashed())
            <div class="row mt-3">
                @if(count($data['sponsorships']) == 0)
                    <div class="col-12 pb-5 white m-md-3 shadow-lg">
                        <div class="row pt-5">
                            <div class="col-12 has-background NORESULT"></div>
                            <div class="col-12 align-text-center">
                                <h3 class="h3-responsive text">No sponsorships have been added</h3>
                                <a class="btn green-btn" onClick="$('#newSponModal').modal('show')"><span class="fa fa-plus"></span> New  Sponsorship</a>
                            </div>
                        </div>
                    </div>
                @else
                <div class="col-12">
                    <h4 class="h4-responsive bold text">Sponsorships</h4>
                </div>
                    @foreach($data['sponsorships'] as $item)
                        @if($item->subcategory != null)
                            @include('cms/inc/itemCard')
                        @endif
                    @endforeach
                    <div class="col-10 mt-3 mx-auto">
                        {{ $data['sponsorships']->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>

@if(!$data['sub_category']->trashed())
<!-- Edit sub category modal -->
<div class="modal fade right" id="editSubModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id="editSubCatForm" action="/cms/categories/sub/update" method="POST">
          <div class="modal-body">
          <div class="row border-bottom pl-md-3">
              <div class="col-md-5">
                <h5 class="h5-responsive">Edit Subcategory</h5>
              </div>
              <div class="col-md-5 ml-auto">
                <input type="hidden" name="sub_id" value="{{$data['sub_category']->id}}" required/>
                <input type="hidden" name="cat_id" value="{{ $data['category']->id }}" required />
                <button type="submit" class="btn btn-sm mb-2 float-right btn-green">Submit</button>
                <button type="button" class="btn btn-sm mb-2 float-right btn-white grey lighten-4" data-dismiss="modal">Cancel</button>
              </div>
            </div>
              @csrf
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Subcategory Name <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="sub_cat_name" value="{{$data['sub_category']->sub_category_name}}" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Cover Image URL <span class="red-text">*</span></label>
                  <input type="url" class="form-control" name="cover_img_url" value="{{$data['sub_category']->cover_image_url}}" require/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Video URL</label>
                  <input type="url" class="form-control" name="video_url" value="{{$data['sub_category']->video_url}}" />
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Video Tag Line</label>
                  <input type="text" class="form-control" name="tag_line" value="{{$data['sub_category']->video_tag_line}}" />
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12">
                  <span class="grey-text fs-14 neg-mt-10">Description <span class="red-text">*</span></span>
                  <textarea class="w-100 md-textarea tinyMiceEditor" name="desc" require>{!! $data['sub_category']->description !!}</textarea>
                </div>
              </div>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- Edit sub category modal -->

<!-- Delete Subcategory confirmation modal -->
<div class="modal fade right" id="delSubCatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side right modal-sm" role="document">
    <div class="modal-content">
        <form id="deleteCatForm" action="/cms/categories/sub/delete" method="POST">
          <div class="modal-body align-text-center">
            <h3 class="h3-responsive text">Delete Subcategory</h3>
            <span class="lead text">Deleting this subcategory will make it in accessible from the general public</span>
            <br /><strong>Do you wish to proceed with this operation?</strong>
            <div class="m-3 align-text-center">
              @csrf
              <input type="hidden" name="id" value="{{ $data['sub_category']->id }}" required />
              <button type="button" data-dismiss="modal" class="btn btn-white grey lighten-3">Cancel</button>
              <button type="submit" class="btn btn-dark red darken-3">Proceed</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<!-- Delete Subcategory confirmation modal -->


<!-- Create new sponsorship modal -->
<div class="modal fade right" id="newSponModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id="newSponCatForm" action="/cms/sponsorships/new" method="POST">
          <div class="modal-body">
          <div class="row border-bottom pl-md-3">
              <div class="col-md-5">
                <h5 class="h5-responsive">New Sponsorship</h5>
              </div>
              <div class="col-md-5 ml-auto">
                <input type="hidden" name="sub_id" value="{{$data['sub_category']->id}}" required/>
                <input type="hidden" name="cat_id" value="{{ $data['category']->id }}" required />
                <button type="submit" class="btn btn-sm mb-2 float-right btn-green">Submit</button>
                <button type="button" class="btn btn-sm mb-2 float-right btn-white grey lighten-4" data-dismiss="modal">Cancel</button>
              </div>
            </div>
              @csrf
              <div class="row">
                <div class="col-md-11 mx-auto md-form mb-0">
                  <label>Title <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="title" require/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Total Units Available <span class="red-text">*</span></label>
                  <input type="number" class="form-control" name="tot_units" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Duration in Month <span class="red-text">*</span></label>
                  <input type="number" class="form-control" name="duration" require/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Price Per Unit <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="price" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Expected Returns (%) <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="ret_percent" require/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Expected Completion Date <span class="red-text">*</span></label>
                  <input type="date" class="form-control" name="comp_date" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label class="active">Location <span class="red-text">*</span></label>
                  <select name="location" class="form-control border-0">
                    @foreach($data['locations'] as $location)
                    <option value="{{$location->id}}">{{$location->location_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12">
                  <span class="grey-text fs-14 neg-mt-10">Description <span class="red-text">*</span></span>
                  <textarea class="w-100 md-textarea tinyMiceEditor" name="desc" require></textarea>
                </div>
              </div>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- Create new sponsorship modal -->
@else
<!-- Restore Subcategory confirmation modal -->
<div class="modal fade right" id="resSubCatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side right modal-sm" role="document">
    <div class="modal-content">
        <form id="restoreCatForm" action="/cms/categories/sub/restore" method="POST">
          <div class="modal-body align-text-center">
            <h3 class="h3-responsive text">Restore Subcategory</h3>
            <span class="lead text">Restoring this subcategory will make it available to the general public</span>
            <br /><strong>Do you wish to proceed with this operation?</strong>
            <div class="m-3 align-text-center">
              @csrf
              <input type="hidden" name="id" value="{{ $data['sub_category']->id }}" required />
              <button type="button" data-dismiss="modal" class="btn btn-white grey lighten-3">Cancel</button>
              <button type="submit" class="btn btn-dark green darken-3">Proceed</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<!-- Restore Subcategory confirmation modal -->
@endif

@endsection