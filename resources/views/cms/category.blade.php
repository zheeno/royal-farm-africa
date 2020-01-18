@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - Category</title>
@endsection
@section('content')
    <div class="container-fluid url-element-tog" data-target="{{$data['target']}}" data-toggle-mode="{{$data['toggle_mode']}}" data-auto-toggle="{{$data['autoToggle']}}">
        <div class="row">
            <div class="col-12">
                <h3 class="h3-responsive text bold">Category</h3>
                <a class="btn" onClick="$('#addNewModal').modal('show')">Add</a>
            </div>
        </div>
    </div>
<!-- Side Modal Top Right -->
<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body p-5">
      </div>
    </div>
  </div>
</div>
<!-- Side Modal Top Right -->
@endsection