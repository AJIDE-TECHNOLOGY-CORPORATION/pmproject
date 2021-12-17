@extends('layouts.admin-layout')
@section('title', 'Notes')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.notes') }}</h3>
                        </div>
                        <div class="card-body shadow-3">
                            <form
                                action="{{ isset($notes) ? url('admin/notes/update/' . $notes->id) : url('admin/notes/create') }}"
                                method="post" id="MyNotesForm">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.title') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="Title" name="title"
                                                id="title" value="{{ isset($notes) ? $notes->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.subject') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="Subject" name="subject"
                                                id="subject" value="{{ isset($notes) ? $notes->subject : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.notes') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control mb-4" placeholder="Notes" rows="6" name="note"
                                                id="note">{{ isset($notes) ? $notes->note : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-footer mt-2">
                                            <button class="btn admin-submit-btn-grad">{{ __('all.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection