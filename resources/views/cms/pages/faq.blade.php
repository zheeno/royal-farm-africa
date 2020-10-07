@extends('layouts.adminator')
@section('title')
<title>{{ config('app.name', 'Laravel') }} | CMS - About Page Setup</title>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="row mb-4">
            <div class="col-md-8">
                <h3 class="h3-responsive"><a href="/cms">CMS</a> / Pages / <strong>FAQ</strong></h3>
            </div>
            <div class="col-md-4">
                <button type="submit" class="float-right btn btn-sm btn-dark deep-purple darken-4"><span class="fa fa-save"></span> Save &amp; Publish</button>
                <a href="/faqs" target="_blank" class="float-right btn btn-sm btn-white grey lighten-3"><span class="fa fa-eye"></span> Preview</a>
            </div>
        </div>
        <div class="alert alert-info">
            <span class="fa fa-star"></span>
            <span>Here you can modify the content of the FAQs page on the website.</span>
        </div>
        @if(@session('success'))
            <div class="alert alert-success">
                <span class="fa fa-check-circle"></span>
                <span>{!! @session('success') !!}</span>
            </div>
        @endif
    </div>
</div>
<div class="row pb-5">
    <!-- add faq form -->
    <div class="col-md-6 mx-auto white shadow-lg p-3 px-4">
        <form id="createFAQForm" class="mx-3" method="POST" action="{{route('pages.faq.create')}}">
            @csrf
            <div class="md-form mb-5">
                <label>Question @error('question')<span class="red-text">({{ $message }})</span>@enderror</label>
                <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" require />
            </div>
            <div class="md-form">
                <span class="grey-text">Answer* @error('answer')<span class="red-text">({{ $message }})</span>@enderror</span>
                <textarea name="answer" class="md-textarea w-100" require></textarea>
            </div>
            <div class="pt-5 align-text-center mb-5">
                <button type="submit" class="btn btn-green">Create FAQ</button>
            </div>
        </form>
    </div>
    <div class="col-md-5 mx-auto white shadow-lg">
    @if(count($data['faqs']) == 0)
        <div class="py-3 px-4">
            <div class="has-background NORESULT pt-3 pb-3"></div>
            <div class="w-100 align-text-center pt-4 pb-5">
                <h5 class="h5-responsive grey-text">No FAQs have been created</h5>
                <a class="btn btn-green"><span class="fa fa-plus"></span> Add FAQ</a>
            </div>
        </div>
    @else
        <h3 class="h3-responsive m-4 green-text">FAQs</h3>
        @foreach($data['faqs'] as $index => $faq)
        <div class="row border-bottom grey lighten-5 my-1">
            <div class="col-12 pb-2 shadow-sm grey lighten-3">
                <a class="bold h4-responsive" onClick="$('#faq_col_ans_{{$index}}').collapse('toggle')">{{$faq->question}}</a>
            </div>
            <div id="faq_col_ans_{{$index}}" class="my-3 px-4 col-12 collapse">
                {!! $faq->answer !!}
                <div class="align-text-right">
                    <a class="blue-text edit-faq" data-faq-id="{{$faq->id}}" data-faq-question="{{$faq->question}}" data-faq-answer="{{$faq->answer}}" ><span class="fa fa-edit"></span> Edit</a>
                    <a class="red-text del-faq" data-faq-id="{{$faq->id}}" data-faq-question="{{$faq->question}}"><span class="fa fa-trash"></span> Delete</a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
    </div>
</div>

<!-- edit faq confirmation modal -->
<div class="modal fade right" id="editFaqModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <h3 class="h3-responsive m-4">Edit FAQ</h3>
        <form action="{{route('pages.faq.update')}}" method="POST">
            <div class="modal-body">
                @csrf
                <input type="hidden" id="edit_faq_id" name="faq_id" required />
                <div class="md-form mb-5">
                    <span class="active">Question @error('_question')<span class="red-text">({{ $message }})</span>@enderror</span><br />
                    <input id="question_editor" type="text" name="_question" class="form-control @error('_question') is-invalid @enderror" require />
                </div>
                <div class="md-form">
                <span class="grey-text">Answer* @error('_answer')<span class="red-text">({{ $message }})</span>@enderror</span><br />
                    <textarea id="answer_editor" name="_answer" class="md-textarea w-100" required></textarea>
                </div>
                <div class="align-text-center mb-4">
                    <button type="button" data-dismiss="modal" class="btn grey lighten-5">Cancel</button>
                    <button type="submit" class="btn btn-green">Update FAQ</button>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- edit faq confirmation modal /-->


<!-- Delete faq confirmation modal -->
<div class="modal fade right" id="deleteFaqModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="{{route('pages.faq.delete')}}" method="POST">
            <div class="modal-body align-text-center">
                @csrf
                <input type="hidden" id="del_faq_id" name="faq_id" required />
                <h2 class="h2-responsive">Delete FAQ</h2>
                <h5 class="h5-responsive">Are you sure you want to Delete this FAQ?</h5>
                <h4 id="faq-question" class="h4-responsive"></h4>
                <button type="button" data-dismiss="modal" class="btn grey lighten-5">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete FAQ</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Delete faq confirmation modal /-->
@endsection