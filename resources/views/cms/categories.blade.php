<?php use App\Http\Controllers\CMSController; ?>

@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - Categories</title>
@endsection
@section('content')
    <div id="url-element-tog" class="container-fluid" data-target="{{$data['target']}}" data-toggle-mode="{{$data['toggle_mode']}}" data-auto-toggle="{{$data['autoToggle']}}">
        <div class="row">
            <div class="col-12">
              <h3 class="h3-responsive"><a href="/cms">CMS</a> / <strong>Categories</strong></h3>
                <a class="btn btn-green" onClick="$('#addNewModal').modal('show')">Add</a>
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
            @if(count($data['categories']) == 0)
              <div class="py-3 px-4 shadow-lg white">
                  <div class="has-background NORESULT pt-3 pb-3"></div>
                  <div class="w-100 align-text-center pt-4 pb-5">
                      <h5 class="h5-responsive grey-text">No categories found</h5>
                  </div>
              </div>
            @else
              @foreach($data['categories'] as $category)
                <div class="row my-3 shadow-sm white">
                  <div class="col-12">
                    <h4 class="h4-responsive mb-0 mt-3"><a href="/cms/categories/{{$category->id}}" class=" green-text">{{$category->category_name}}</a>@if($category->trashed())&nbsp;<small class="red-text">(Trashed)</small>@endif</h4>
                  </div>
                  <div class="col-12">
                    <p class="text">{{CMSController::wrap_strip($category->description, 200)}}</p>
                    <div>
                      @foreach($category->subcategories as $subcategory)
                        <a href="/cms/categories/{{$category->id}}/{{$subcategory->id}}" class="badge bg-green white-text my-2 mx-1 py-2">{{$subcategory->sub_category_name}}</a>
                      @endforeach
                    </div>
                    <div class="row grey lighten-3">
                    @if(count($category->subcategories) > 0)
                      <div class="col px-2 py-1 align-text-center">
                        <strong class="text">{{number_format(count($category->subcategories))}}</strong>
                        <br /><small>Subcategories</small>
                      </div>
                    @endif
                    @if(count($category->sponsorships) > 0)
                      <div class="col px-2 py-1 align-text-center border-left border-right">
                        <strong class="text">{{number_format(count($category->sponsorships))}}</strong>
                        <br /><small>Sponsorships</small>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
        </div>
    </div>








<!-- Side Modal Top Right -->
<div class="modal fade right" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id="newCatForm" action="/cms/categories/new" method="POST">
          <div class="modal-body">

          <div class="row border-bottom pl-md-3">
              <div class="col-md-5">
                <h5 class="h5-responsive">Add Category</h5>
              </div>
              <div class="col-md-5 ml-auto">
                <button type="submit" class="btn btn-sm mb-2 float-right btn-green">Submit</button>
                <button type="button" class="btn btn-sm mb-2 float-right btn-white grey lighten-4" data-dismiss="modal">Cancel</button>
              </div>
            </div>
              @csrf
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Category Name <span class="red-text">*</span></label>
                  <input type="text" class="form-control" name="cat_name" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Tag Line</label>
                  <input type="text" class="form-control" name="tag_line" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Cover Image URL <span class="red-text">*</span></label>
                  <input type="url" class="form-control" name="cover_img_url" require/>
                </div>
                <div class="col-md-5 mx-auto md-form mb-0">
                  <label>Video URL</label>
                  <input type="url" class="form-control" name="video_url" />
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
<!-- Side Modal Top Right -->
@endsection