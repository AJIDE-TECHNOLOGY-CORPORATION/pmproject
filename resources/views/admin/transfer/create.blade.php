@extends('layouts.admin-layout')
@section('title', 'transfer')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.transfer') }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ isset($transfer) ? url('admin/bank/transfer/update/' . $transfer->id) : url('admin/bank/transfer/create') }}"
                                method="post" id="MyTransferForm">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.from_name') }}:<span
                                                    class="text-red">*</span></label>
                                            @php
                                                $customers = App\Bank::get();
                                            @endphp
                                            <select class="form-control select2" name="from_id" id="from_id">
                                                <option value="">--{{ __('all.choose_name') }}--</option>
                                                @foreach ($customers as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ isset($transfer) && $transfer->from_id == $row->id ? 'selected' : '' }}>
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.to_name') }}:<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control select2" name="to_id" id="to_id">
                                                <option value="">--{{ __('all.choose_name') }}--</option>
                                                @foreach ($customers as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ isset($transfer) && $transfer->to_id == $row->id ? 'selected' : '' }}>
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.amount') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" placeholder="{{ __('all.amount') }}"
                                                name="amount" id="amount"
                                                value="{{ isset($transfer) ? $transfer->amount : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.date') }}: </label>
                                            <input type="date" class="form-control" placeholder="{{ __('all_date') }}"
                                                name="date" id="date"
                                                value="{{ isset($transfer) ? $transfer->date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.reference') }}: </label>
                                            <input type="text" class="form-control" placeholder="{{ __('all.reference') }}"
                                                name="reference" id="reference"
                                                value="{{ isset($transfer) ? $transfer->balance : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.description') }}:</label>
                                            <textarea class="form-control mb-4" placeholder="{{ __('all.description') }}"
                                                rows="6" name="description"
                                                id="description">{{ isset($transfer) ? $transfer->bank_address : '' }}</textarea>
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
