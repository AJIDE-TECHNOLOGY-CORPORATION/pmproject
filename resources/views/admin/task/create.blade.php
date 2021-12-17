@extends('layouts.admin-layout')
@section('title', 'Tasks')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.tasks') }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ isset($task) ? url('admin/tasks/update/' . $task->id) : url('admin/tasks/create') }}"
                                method="post" id="MyTaskForm">
                                {{ @csrf_field() }}

                                @php
                                    $projects = App\Project::latest()->get();
                                @endphp

                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.project') }}</label>
                                            <select class="form-control select2" data-placeholder="Choose one (with searchbox)"
                                                    id="project_id" name="project_id">
                                                <option value="">--{{ __('all.choose_project)') }}--</option>
                                                @foreach ($projects as $row)
                                                    <option value="{{ $row->id }}" {{isset($task)&&$task->project_id==$row->id ? 'selected':''}}>{{ $row->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.title') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="Title" name="title"
                                                   id="title" value="{{ isset($task) ? $task->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.start_date') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" placeholder="{{ __('all.start_date') }}"
                                                   name="start_date" id="start_date"
                                                   value="{{ isset($task) ? $task->start_date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.deadline_date') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" placeholder="{{ __('all.deadline_date') }}"
                                                   name="deadline_date" id="deadline_date"
                                                   value="{{ isset($task) ? $task->deadline_date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.description') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control mb-4" placeholder="description" rows="6" name="description"
                                                      id="description">{{ isset($task) ? $task->description : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.status') }}:<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control select2" name="status"
                                                    id="status" data-placeholder="Choose one (with searchbox)">
                                                <option value="0" {{ isset($task) && $task->status==0 ? 'selected': "" }}> {{__('all.not_started')}}</option>
                                                <option value="1" {{ isset($task) && $task->status==1 ? 'selected': "" }}> {{__('all.progressing')}}</option>
                                                <option value="2" {{ isset($task) && $task->status==2 ? 'selected': "" }}> {{__('all.cancelled')}}</option>
                                                <option value="3" {{ isset($task) && $task->status==3 ? 'selected': "" }}> {{__('all.completed')}}</option>
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
