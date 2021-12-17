@extends('layouts.admin-layout')
@section('title', 'Accounts')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.accounts') }}</h3>
                        </div>
                        <div class="card-body shadow-3">
                            <form
                                action="{{ isset($accounts) ? url('admin/bank/accounts/update/' . $accounts->id) : url('admin/bank/accounts/create') }}"
                                method="post" id="MyAccountsForm">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.bank_holder_name') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('all.bank_holder_name') }}" name="name" id="name"
                                                value="{{ isset($accounts) ? $accounts->name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.bank_name') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="{{ __('all.bank_name') }}"
                                                name="bank_name" id="bank_name"
                                                value="{{ isset($accounts) ? $accounts->bank_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.account_number') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('all.account_number') }}" name="account_number"
                                                id="account_number"
                                                value="{{ isset($accounts) ? $accounts->account_number : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.opening_balance') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('all.opening_balance') }}" name="balance" id="balance"
                                                value="{{ isset($accounts) ? $accounts->balance : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address') }}:</label>
                                            <textarea class="form-control mb-4" placeholder="{{ __('all.address') }}"
                                                rows="6" name="bank_address"
                                                id="bank_address">{{ isset($accounts) ? $accounts->bank_address : '' }}</textarea>
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
