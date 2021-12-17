@extends('layouts.admin-layout')
@section('title', 'todos')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.todos') }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ isset($todo) ? url('admin/todos/update/' . $todo->id) : url('admin/todos/create') }}"
                                method="post" id="MyTodoForm">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.title') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="Title" name="title"
                                                id="title" value="{{ isset($todo) ? $todo->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.due_date') }}:<span
                                                    class="text-red">*</span></label>
                                                    <input type="date" class="form-control" placeholder="{{ __('all_date') }}"
                                                name="due_date" id="date"
                                                value="{{ isset($todo) ? $todo->due_date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.description') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control mb-4" placeholder="description" rows="6" name="description"
                                                id="description">{{ isset($todo) ? $todo->description : '' }}</textarea>
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
