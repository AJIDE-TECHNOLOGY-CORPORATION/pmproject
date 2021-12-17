@extends('layouts.admin-layout')
@section('title', 'Payment Updation')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-outline shadow-3">
                        <div class="card-header admin-cart-header">
                            <h3 class="card-title col-md-10">{{ __('all.add_payments') }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ isset($payment) ? url('admin/payments/update/' . $payment->id) : url('admin/payments/create') }}"
                                method="post" id="MyPaymentForm">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.date') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control mb-4" name="paid_date" id="paid_date"
                                                value="{{ isset($payment) ? $payment->paid_date : \Carbon\Carbon::today()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.payment_number') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" name="payment_number"
                                                id="payment_number"
                                                value="{{ isset($payment) ? $payment->payment_number : generate_paymentnumber() }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            @php
                                                $invoices = App\Invoice::where('invoice_status', 0)->get();
                                            @endphp
                                            <label class="form-label">{{ __('all.invoice') }}</label>
                                            @if (isset($payment))
                                                <select class="form-control select2" name="invoice_number"
                                                    id="invoice_number" data-placeholder="Choose one (with searchbox)">
                                                    <option value="{{ $payment->invoice_number }}">
                                                        {{ $payment->invoice_number }} </option>
                                                </select>
                                            @else
                                                <select class="form-control select2" name="invoice_number"
                                                    id="invoice_number" data-placeholder="Choose one (with searchbox)">
                                                    <option value="">--{{ __('all.choose_invoice') }}--</option>
                                                    @foreach ($invoices as $row)
                                                        <option value="{{ $row->invoice_number }}">
                                                            {{ $row->invoice_number }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-md-8">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.amount') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" name="paid_amount" id="paid_amount"
                                                value="{{ isset($payment) ? $payment->paid : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.payment_mode') }}</label>
                                            @php
                                                $payment_modes = App\PaymentMode::latest()->get();
                                            @endphp
                                            <select class="form-control select2" name="payment_mode" id="payment_mode"
                                                data-placeholder="Choose one (with searchbox)">
                                                <option value="">--{{ __('all.choose_payment_mode') }}--</option>
                                                @foreach ($payment_modes as $row)
                                                    <option value="{{ $row->name }}"
                                                        {{ isset($payment) && $payment->payment_mode == $row->name ? 'selected' : '' }}>
                                                        {{ $row->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.notes') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control mb-4" rows="9" name="note"
                                                id="note">{{ isset($payment) ? $payment->note : '' }}</textarea>
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
@push('js')
    <script>
        /* customer payment entry */
        $('select[name="invoice_number"]').on('change', function() {
            'use strict';
            var invoice_number = $(this).val();
            var url = "{{ url('admin/payments/get-invoice') }}" + '/' + invoice_number;
            $.get(url, function(data) {
                $('#paid_amount').val(parseFloat(data.invoice.total) - parseFloat(data.invoice.paid));
            })
        });
    </script>
@endpush
