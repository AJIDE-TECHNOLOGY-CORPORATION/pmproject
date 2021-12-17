@extends('layouts.admin-layout')
@section('title', 'projects')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.projects') }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ isset($project) ? url('admin/projects/update/' . $project->id) : url('admin/projects/create') }}"
                                method="post" id="MyProjectForm">
                                {{ @csrf_field() }}

                                 @php
                                    $customers = App\Customer::latest()->get();
                                @endphp

                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.customer') }}<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control select2" data-placeholder="Choose one (with searchbox)"
                                                    id="customer_id" name="customer_id">
                                                <option value="">--{{ __('all.choose_customer)') }}--</option>
                                                @foreach ($customers as $row)
                                                    <option value="{{ $row->id }}" {{isset($project)&&$project->customer_id==$row->id ? 'selected':''}}>{{ $row->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-8 col-md-8">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.title') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="Title" name="title"
                                                id="title" value="{{ isset($project) ? $project->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.start_date') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" placeholder="{{ __('all.start_date') }}"
                                                   name="start_date" id="start_date"
                                                   value="{{ isset($project) ? $project->start_date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.end_date') }}:<span
                                                    class="text-red">*</span></label>
                                                    <input type="date" class="form-control" placeholder="{{ __('all.end_date') }}"
                                                name="end_date" id="date"
                                                value="{{ isset($project) ? $project->end_date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.description') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control mb-4" placeholder="description" rows="6" name="description"
                                                id="description">{{ isset($project) ? $project->description : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.status') }}:<span
                                                    class="text-red">*</span></label>
                                                    <select class="form-control select2" name="status"
                                                            id="status" data-placeholder="Choose one (with searchbox)">
                                                            <option value="0" {{ isset($project) && $project->status==0 ? 'selected': "" }}> {{__('all.not_started')}}</option>
                                                            <option value="1" {{ isset($project) && $project->status==1 ? 'selected': "" }}> {{__('all.progressing')}}</option>
                                                            <option value="2" {{ isset($project) && $project->status==2 ? 'selected': "" }}> {{__('all.cancelled')}}</option>
                                                            <option value="3" {{ isset($project) && $project->status==3 ? 'selected': "" }}> {{__('all.completed')}}</option>
                                                    </select>
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
