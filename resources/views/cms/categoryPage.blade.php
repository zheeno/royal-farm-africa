<?php use App\Http\Controllers\CMSController; ?>
@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - Category - {{$data['category']->category_name}}</title>
@endsection
@section('content')
    <div class="container-fluid">        
        <div class="row ">
            <div class="col-12 p-0">
                <div class="jumbotron card shadow-none card-image  p-0 hero-2" style="background-image:url({{$data['category']->cover_image_url}})">
                    <div class="mask py-md-5 px-md-5">
                        <div class="row text-white py-5 px-4 my-5">
                            <div class="col-md-5 mr-auto">
                                <h1 class="fa-3x bold mb-0 white-text mb-0 wow fadeIn" data-wow-delay="0.6s"  data-wow-duration="5s">{{$data['category']->category_name}}</h1>
                                <h5 class="fa-2x bold mb-0 white-text wow fadeIn" data-wow-delay="0.6s"  data-wow-duration="5s">{{$data['category']->tag_line}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
              <h3 class="h3-responsive"><a href="/cms">CMS</a> / <a href="/cms/categories">Categories</a> / <strong>{{$data['category']->category_name}}</strong>@if($data['category']->trashed())&nbsp;<small class="red-text">(Trashed)</small>@endif</h3>
                @if(@session('success'))
                    <div class="alert alert-success">
                        <span class="fa fa-check-circle"></span>
                        <span>{!! @session('success') !!}</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
          <div class="col-md-7">
            <div class="row">
              <div class="col-12">
                <h5 class="float-left text h5-responsive">Description</h5>
                @if($data['category']->trashed())
                <a class="float-right green-text mx-3" onClick="$('#resCatModal').modal('show')"><span class="fa fa-refresh"></span> Restore</a>
                @else
                <a class="float-right red-text mx-3" onClick="$('#delCatModal').modal('show')"><span class="fa fa-trash"></span> Delete</a>
                <a class="float-right blue-text" onClick="$('#addNewModal').modal('show')"><span class="fa fa-edit"></span> Edit</a>
                @endif
              </div>
            </div>
            {!! $data['category']->description !!}
          </div>
          <div class="col-md-5">
            <div class="row">
              <div class="col-12">
                <h5 class="float-left text h5-responsive">Subcategories</h5>
                @if(!$data['category']->trashed())
                  <a class="float-right blue-text" onClick="$('#addNewSubModal').modal('show')"><span class="fa fa-plus"></span> New</a>
                @endif
              </div>
            </div>
            @if(count($data['category']->subcategories) == 0)
              <div class="py-3 px-4 shadow-lg white">
                  <div class="has-background NORESULT pt-3 pb-3"></div>
                  <div class="w-100 align-text-center pt-4 pb-5">
                      <h5 class="h5-responsive grey-text">No subcategories found</h5>
                  </div>
              </div>
            @else
              <div class="row shadow-lg white">
              <?php $sub_cats = CMSController::getSubCategories($data['category']->id) ?>
                @foreach($sub_cats as $subcat)
                  <div class="col-12 px-2 py-3 border-bottom">
                    <h5 class="h5-responsive mb-0"><a class="green-text" href="/cms/categories/{{$data['category']->id}}/{{$subcat->id}}">{{ $subcat->sub_category_name }}</a>@if($subcat->trashed())<small class="red-text">&nbsp;(Trashed)</small>@endif</h5>
                    {{ CMSController::wrap_strip($subcat->description, 100) }}
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
    </div>


@if(!$data['category']->trashed())
<!-- Edit category modal -->
<div class="modal fade right" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id="newCatForm" action="/cms/categories/update" method="POST">
          <div class="modal-body">

          <div class="row border-bottom pl-md-3">
              <div class="col-md-5">
                <h5 class="h5-responsive">Edit Category</h5>
              </div>
              <div class="col-md-5 ml-auto">
                <button type="submit" class="btn btn-sm mb-2 float-right btn-green">Submit</button>
                <button type="button" class="btn btn-sm mb-2 float-right btn-white grey lighten-4" data-dismiss="modal">Cancel</button>
              </div>
            </div>
              @csrf
              <input type="hidden" name="cat_id" value="{{ $data['category']->id }}" required />
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Category Name <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="cat_name" value="{{ $data['category']->category_name }}" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Tag Line</label>
                  <input type="text" class="form-control" name="tag_line" value="{{ $data['category']->tag_line }}" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Cover Image URL <span class="red-text">*</span></label>
                  <input type="url" class="form-control" name="cover_img_url" value="{{ $data['category']->cover_image_url }}" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Video URL</label>
                  <input type="url" class="form-control" name="video_url" value="{{ $data['category']->video_url }}" />
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12">
                  <span class="grey-text fs-14 neg-mt-10">Description <span class="red-text">*</span></span>
                  <textarea class="w-100 md-textarea tinyMiceEditor" name="desc" require>{{ $data['category']->description }}</textarea>
                </div>
              </div>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- Edit category modal -->


<!-- Delete category confirmation modal -->
<div class="modal fade right" id="delCatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side right modal-sm" role="document">
    <div class="modal-content">
        <form id="deleteCatForm" action="/cms/categories/delete" method="POST">
          <div class="modal-body align-text-center">
            <h3 class="h3-responsive text">Delete Category</h3>
            <span class="lead text">Deleting this category will make it in accessible from the general public</span>
            <br /><strong>Do you wish to proceed with this operation?</strong>
            <div class="m-3 align-text-center">
              @csrf
              <input type="hidden" name="id" value="{{ $data['category']->id }}" required />
              <button type="button" data-dismiss="modal" class="btn btn-white grey lighten-3">Cancel</button>
              <button type="submit" class="btn btn-dark red darken-3">Proceed</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<!-- Delete category confirmation modal -->

<!-- Add new sub category modal -->
<div class="modal fade right" id="addNewSubModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id="newSubCatForm" action="/cms/categories/sub/new" method="POST">
          <div class="modal-body">

          <div class="row border-bottom pl-md-3">
              <div class="col-md-5">
                <h5 class="h5-responsive">New Subcategory</h5>
              </div>
              <div class="col-md-5 ml-auto">
                <button type="submit" class="btn btn-sm mb-2 float-right btn-green">Submit</button>
                <button type="button" class="btn btn-sm mb-2 float-right btn-white grey lighten-4" data-dismiss="modal">Cancel</button>
              </div>
            </div>
              @csrf
              <input type="hidden" name="cat_id" value="{{ $data['category']->id }}" required />
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Subcategory Name <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="sub_cat_name" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Cover Image URL <span class="red-text">*</span></label>
                  <input type="url" class="form-control" name="cover_img_url" require/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Video URL</label>
                  <input type="url" class="form-control" name="video_url" />
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Video Tag Line</label>
                  <input type="text" class="form-control" name="tag_line" />
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
<!-- Add new sub category modal -->
@else
<!-- Restore category confirmation modal -->
<div class="modal fade right" id="resCatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side right modal-sm" role="document">
    <div class="modal-content">
        <form id="restoreCatForm" action="/cms/categories/restore" method="POST">
          <div class="modal-body align-text-center">
            <h3 class="h3-responsive text">Restore Category</h3>
            <span class="lead text">Restoring this category will make it available to the general public</span>
            <br /><strong>Do you wish to proceed with this operation?</strong>
            <div class="m-3 align-text-center">
              @csrf
              <input type="hidden" name="id" value="{{ $data['category']->id }}" required />
              <button type="button" data-dismiss="modal" class="btn btn-white grey lighten-3">Cancel</button>
              <button type="submit" class="btn btn-dark green darken-3">Proceed</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<!-- Restore category confirmation modal -->
@endif

@endsection