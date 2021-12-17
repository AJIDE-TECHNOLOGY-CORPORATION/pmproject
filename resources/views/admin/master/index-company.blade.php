@extends('layouts.admin-layout')
@section('title', 'Company Settings')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline  shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.company_settings') }}</h3>
                                </div>
                                <div class="card-body  shadow-3">
                                    <div class="e-table">
                            <form action="{{ url('admin/masters/company/') }}" method="post" id="MyCompanyForm"
                                enctype='multipart/form-data'>
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.site_logo') }}:</label>
                                            <input type="file" class="dropify"
                                                data-default-file="{{ isset($site['site_logo']) && !empty($site['site_logo']) && File::exists('uploads/logo/' . $site['site_logo']) ? asset('uploads/logo/' . $site['site_logo']) : asset('uploads/logo/logo.png') }}"
                                                data-max-file-size="2M" name="site_logo" id="site_logo"
                                                data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG"
                                                accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="180"
                                                data-show-remove="false" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.favicon') }}:</label>
                                            <input type="file" class="dropify"
                                                data-default-file="{{ isset($site['favicon']) && !empty($site['favicon']) && File::exists('uploads/favicon/' . $site['favicon']) ? asset('uploads/favicon/' . $site['favicon']) : asset('uploads/favicon/favicon.png') }}"
                                                data-max-file-size="2M" name="favicon" id="favicon"
                                                data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG"
                                                accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="180"
                                                data-show-remove="false" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.company_name') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name"
                                                name="company_name" id="company_name"
                                                value="{{ isset($site['company_name']) && !empty($site['company_name']) ? $site['company_name'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.site_title') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name"
                                                name="site_title" id="site_title"
                                                value="{{ isset($site['site_title']) && !empty($site['site_title']) ? $site['site_title'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.phone_number') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" name="company_phone"
                                                id="company_phone"
                                                value="{{ isset($site['company_phone']) && !empty($site['company_phone']) ? $site['company_phone'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.country') }}</label>
                                            @php
                                                $countries = App\Country::get();
                                            @endphp
                                            <select class="form-control select2"
                                                data-placeholder="Choose one (with searchbox)" name="company_country"
                                                id="company_country">
                                                <option value="">--{{ __('all.choose_country') }}--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->country_code }}"
                                                        {{ isset($site['company_country']) && !empty($site['company_country']) && $site['company_country'] == $row->country_code ? 'selected' : '' }}>
                                                        {{ $row->country_code }}
                                                        ({{ $row->country_name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.state') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" name="company_state"
                                                id="company_state"
                                                value="{{ isset($site['company_state']) && !empty($site['company_state']) ? $site['company_state'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.city') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" name="company_city"
                                                id="company_city"
                                                value="{{ isset($site['company_city']) && !empty($site['company_city']) ? $site['company_city'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.zip_code') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" name="company_zip" id="company_zip"
                                                value="{{ isset($site['company_zip']) && !empty($site['company_zip']) ? $site['company_zip'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address_1') }}<span
                                                    class="text-red">*</span></label>
                                            <textarea type="text" class="form-control mb-4" name="company_address1"
                                                id="company_address1">  {{ isset($site['company_address1']) && !empty($site['company_address1']) ? $site['company_address1'] : '' }} </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address_2') }}</label>
                                            <textarea type="text" class="form-control mb-4" name="company_address2"
                                                id="company_address2">  {{ isset($site['company_address2']) && !empty($site['company_address2']) ? $site['company_address2'] : '' }} </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-footer mt-2">
                                            <button class="btn admin-submit-btn-grad btn-sm">{{ __('all.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>          </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict';
        CKEDITOR.replace('company_address1');
        CKEDITOR.replace('company_address2');
    </script>
@endpush