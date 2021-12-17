@extends('layouts.admin-layout')
@section('title', 'Email Settings')
@section('content')
<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline  shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.email_settings') }}</h3>
                                </div>
                                <div class="card-body  shadow-3">
                                    <div class="e-table">
                                <form action="{{ url('admin/masters/email') }}" method="post" id="MyEmailMaster"
                                  enctype='multipart/form-data'>
                                {{ @csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="sitelogo">{{ __('all.mail_driver')}}</label>
                                            <input type="text" class="form-control" id="mail_driver" name="mail_driver"
                                                   value="{{ (isset($site['mail_driver']) && !empty($site['mail_driver'])) ? $site['mail_driver'] :'' }}">
                                        </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="lastName">{{ __('all.mail_host')}}</label>
                                            <input type="text" class="form-control" id="mail_host" name="mail_host"
                                                   value="{{ (isset($site['mail_host']) && !empty($site['mail_host'])) ? $site['mail_host'] :'' }}">
                                        </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="lastName">{{ __('all.mail_port')}}</label>
                                            <input type="text" class="form-control" id="mail_port" name="mail_port"
                                                   value="{{ (isset($site['mail_port']) && !empty($site['mail_port'])) ? $site['mail_port'] :'' }}">
                                        </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="lastName">{{ __('all.mail_username')}}</label>
                                            <input type="text" class="form-control" id="mail_user_name" name="mail_user_name"
                                                   value="{{ (isset($site['mail_user_name']) && !empty($site['mail_user_name'])) ? $site['mail_user_name'] :'' }}">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="sitelogo">{{ __('all.mail_password')}}</label>
                                            <input type="password" class="form-control" id="mail_user_password" name="mail_user_password"
                                                   value="{{ (isset($site['mail_user_password']) && !empty($site['mail_user_password'])) ? $site['mail_user_password'] :'' }}">
                                        </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="lastName">{{ __('all.mail_encryption')}}</label>
                                            <input type="text" class="form-control" id="mail_encryption" name="mail_encryption"
                                                   value="{{ (isset($site['mail_encryption']) && !empty($site['mail_encryption'])) ? $site['mail_encryption'] :'' }}">
                                        </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="lastName">{{ __('all.mail_from_address')}}</label>
                                            <input type="text" class="form-control" id="mail_from_address" name="mail_from_address"
                                                   value="{{ (isset($site['mail_from_address']) && !empty($site['mail_from_address'])) ? $site['mail_from_address'] :'' }}">
                                        </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label for="lastName">{{ __('all.mail_from_name')}}</label>
                                            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                                   value="{{ (isset($site['mail_from_name']) && !empty($site['mail_from_name'])) ? $site['mail_from_name'] :'' }}">
                                        </div>
                                    </div>
                                    </div>
                                
                                    <button class="btn admin-submit-btn-grad btn-sm " type="submit">{{ __('all.update')}}</button>
                                </form>
                                </div>
                    </div>
                </div>
            </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection