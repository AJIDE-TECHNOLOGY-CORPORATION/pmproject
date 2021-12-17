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
                                    <h3 class="card-title">{{ __('all.payment_settings') }}</h3>
                                </div>
                                <div class="card-body  shadow-3">
                                    <div class="e-table">
                                        <form action="{{ url('admin/masters/payment') }}" method="post" id="MyPaymentMaster">
                                        {{ @csrf_field() }}

                                        <h4 class="mb-3">{{ __('all.stripe')}}</h4>
                                            <div class="custom-control custom-switch custom-switch-color custom-control-inline">
                                                <input type="checkbox" class="custom-control-input bg-dark" name="stripe_status" id="stripe_status" {{ ((isset($site['stripe_status']) && !empty($site['stripe_status'])) ? (($site['stripe_status']==1) ? 'checked=""':'') : "")}}>
                                                <label class="custom-control-label" for="stripe_status">  {{__('all.stripe_status')}}</label>
                                            </div>
                                        <p><small>{{ __('all.stripe_details')}}</small>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="firstName">{{ __('all.stripe_key')}}</label>
                                                <input type="text" class="form-control" id="stripe_key"
                                                       name="stripe_key"
                                                       value="{{ (isset($site['stripe_key']) && !empty($site['stripe_key'])) ? $site['stripe_key'] :'' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="lastName">{{ __('all.stripe_secret')}}</label>
                                                <input type="text" class="form-control" id="stripe_secret"
                                                       name="stripe_secret"
                                                       value="{{ (isset($site['stripe_secret']) && !empty($site['stripe_secret'])) ? $site['stripe_secret'] :'' }}">
                                            </div>
                                        </div>
                                        <hr class="mb-4">
                                            <h4 class="mb-3">{{ __('all.paypal')}}</h4>
                                            <div class="custom-control custom-switch custom-switch-color custom-control-inline">
                                                <input type="checkbox" class="custom-control-input bg-dark" name="paypal_status" id="paypal_status" {{ ((isset($site['paypal_status']) && !empty($site['paypal_status'])) ? (($site['paypal_status']==1) ? 'checked=""':'') : "")}}>
                                                <label class="custom-control-label" for="paypal_status">  {{__('all.paypal_status')}}</label>
                                            </div>
                                            <p><small>{{ __('all.paypal_details')}}</small>
                                            </p>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="firstName">{{ __('all.paypal_client_id')}}</label>
                                                    <input type="text" class="form-control" id="paypal_client_id"
                                                           name="paypal_client_id"
                                                           value="{{ (isset($site['paypal_client_id']) && !empty($site['paypal_client_id'])) ? $site['paypal_client_id'] :'' }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="lastName">{{ __('all.paypal_secret')}}</label>
                                                    <input type="text" class="form-control" id="paypal_secret"
                                                           name="paypal_secret"
                                                           value="{{ (isset($site['paypal_secret']) && !empty($site['paypal_secret'])) ? $site['paypal_secret'] :'' }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">{{ __('all.paypal_mode') }}</label>
                                                    <select type="text" class="form-control mb-4 select2" name="paypal_mode" id="paypal_mode">
                                                        <option value="">--{{ __('all.choose_paypal_mode') }}--</option>
                                                        <option value="1" {{ isset($site['paypal_mode']) && !empty($site['paypal_mode']) && $site['paypal_mode'] == '1' ? 'selected' : '' }}> {{ __('all.sandbox') }}</option>
                                                        <option value="2" {{ isset($site['paypal_mode']) && !empty($site['paypal_mode']) && $site['paypal_mode'] == '2' ? 'selected' : '' }}> {{ __('all.live')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr class="mb-4">
                                            <h4 class="mb-3">{{ __('all.razorpay')}}</h4>
                                            <div class="custom-control custom-switch custom-switch-color custom-control-inline">
                                                <input type="checkbox" class="custom-control-input bg-dark" name="razorpay_status" id="razorpay_status" {{ ((isset($site['razorpay_status']) && !empty($site['razorpay_status'])) ? (($site['razorpay_status']==1) ? 'checked=""':'') : "")}}>
                                                <label class="custom-control-label" for="razorpay_status">  {{__('all.razorpay_status')}}</label>
                                            </div>
                                            <p><small>{{ __('all.razorpay_details')}}</small>
                                            </p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="firstName">{{ __('all.razorpay_key')}}</label>
                                                    <input type="text" class="form-control" id="razorpay_key"
                                                           name="razorpay_key"
                                                           value="{{ (isset($site['razorpay_key']) && !empty($site['razorpay_key'])) ? $site['razorpay_key'] :'' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="lastName">{{ __('all.razorpay_secret')}}</label>
                                                    <input type="text" class="form-control" id="razorpay_secret"
                                                           name="razorpay_secret"
                                                           value="{{ (isset($site['razorpay_secret']) && !empty($site['razorpay_secret'])) ? $site['razorpay_secret'] :'' }}">
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

