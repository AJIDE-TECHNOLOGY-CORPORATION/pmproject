@extends('layouts.admin-layout')
@section('title', 'Account Settings')
@section('content')
<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline  shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.account_settings') }}</h3>
                                </div>
                                <div class="card-body  shadow-3">
                                    <div class="e-table">
                            <form action="{{ url('admin/masters/account/') }}" method="post" id="MyAccountForm"
                                enctype='multipart/form-data'>
                                {{ @csrf_field() }}

                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.upload_photo') }}:</label>
                                            <input type="file" class="dropify"
                                                data-default-file="{{ isset(Auth::user()->avatar) && !empty(Auth::user()->avatar) && File::exists('uploads/profile/' . Auth::user()->avatar) ? asset('uploads/profile/' . Auth::user()->avatar) : asset('uploads/profile/default.png') }}"
                                                data-max-file-size="2M" name="avatar"
                                                data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG"
                                                accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="200"
                                                data-show-remove="false" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.name') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name" name="name"
                                                id="name" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.phone') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Phone" name="phone"
                                                id="phone" value="{{ Auth::user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.email') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="email" class="form-control mb-4" name="email" id="email"
                                                value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.password') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="password" class="form-control mb-4" name="password" id="password"
                                                placeholde="password" autocomplete="on">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-footer mt-2">
                                            <button class="btn admin-submit-btn-grad btn-sm" type="submit">{{ __('all.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                    </div>
    </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection