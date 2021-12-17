@extends('layouts.admin-layout')
@section('title', 'Estimate')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-dark shadow-3">
                        <div class="card-body">
                            <div class="row pt-4">
                                <div class="col-lg-6 ">
                                    <p class="h5 font-weight-bold">{{ __('all.bill_to') }}</p>
                                    {{ $estimate->customer->display_name }}
                                    <address>
                                        {{ $estimate->customer->billing_address1 }}<br>
                                        {{ $estimate->customer->billing_state }}<br>
                                        {{ $estimate->customer->billing_zip }}<br>
                                        {{ $estimate->customer->phone }}
                                    </address>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <h2 class="font-weight-bold">{{ __('all.estimate') }}</h2>
                                    <span>{{ __('all.estimate_no') }}:</span>
                                    <strong>{{ $estimate->estimate_number }}</strong>
                                    <br>
                                    <span>{{ __('all.estimate_date') }}:</span>
                                    <strong>{{ dateFormat($estimate->estimate_date) }}</strong>
                                    <br>
                                    <span>{{ __('all.estimate_due_date') }}:</span>
                                    <strong>{{ dateFormat($estimate->estimate_due_date) }}</strong>
                                </div>
                            </div>
                            @php
                                $settings = new App\MasterSetting();
                                $site = $settings->siteData();
                                $customers = App\Customer::latest()->get();
                                $products = App\Item::where('is_active', 1)->get();
                                $taxes = App\TaxType::where('is_active', 1)->get();
                                $currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
                            @endphp
                            <input type="hidden" value="{{ $estimate->id }}" name="estimateId" id="estimateId" />
                            <div class="table-responsive push">
                                <table class="table table-bordered table-hover text-nowrap" id="estimate-table">
                                    <tr class=" ">
                                        <th>{{ __('all.product') }}</th>
                                        <th class="text-center">{{ __('all.qty') }}</th>
                                        <th class="text-right">{{ __('all.unit_price') }}</th>
                                        <th class="text-right">{{ __('all.amount') }}</th>
                                    </tr>
                                </table>
                                <input type="hidden" name="tax_rate" id="tax_rate" />
                                <input type="hidden" name="tax_name" id="tax_name" />
                                <input type="hidden" name="tax_percentage" id="tax_percentage" />
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border ">
                                            <table class="table mb-0 ">
                                                <tr>
                                                    <th>{{ __('all.subtotal') }}:{{ $currency }} </th>
                                                    <td class="text-right">{{ $estimate->sub_total }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('all.tax') }}:{{ $currency }} <span
                                                            class="text-regular"></span></th>
                                                    <td class="text-right"> {{ $estimate->tax_amount }} </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('all.total') }}:{{ $currency }} </th>
                                                    <td class="text-right text-dark">
                                                        <h4><strong>{{ $estimate->total }}</strong></h4>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p class="text-muted text-center">{{ __('all.bill_footer_msg') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            'use strict';
            var i = 0,
                payable = 0;
            /* to load already available estimate items */
            var estimateId = $('#estimateId').val();
            if (estimateId != "") {
                /* if the estimate is non empty */
                var url = "{{ url('admin/estimates/get-estimate-product') }}" + '/' + estimateId;
                var count = 0;
                $.get(url, function(data) {
                    $.each(data.data, function(key) {
                        var product_name = data.data[count].product_name;
                        var product_price = data.data[count].product_price;
                        var product_quantity = data.data[count].product_quantity;
                        var product_total = parseInt(data.data[count].product_quantity) *
                            parseFloat(data.data[count].product_price);
                        payable = payable + product_total;
                        var markup = '<tr id="row' + i +
                            '" class="no"> <td class="text-left"> <h6>' + product_name +
                            '<input type="hidden" name="name[]" value="' + product_name +
                            '" readonly/></h6></td> <td class="text-dark unit"> <span class="unit_qty"> ' +
                            product_quantity +
                            '</span> <input class="qty_product" type="hidden" name="qty[]" value="' +
                            product_quantity +
                            '" readonly/></td> <td class="text-dark qty"> <span class="unit_price">' +
                            product_price +
                            '</span> <input type="hidden" class="price_product unit" name="price[]" value="' +
                            product_price +
                            '" readonly/></td> <td class="total"> <span class="unit_total"> ' +
                            product_total +
                            '</span><input type="hidden" class="total_product" name="total[]" value="' +
                            product_total + '" readonly/></td></tr>';
                        $("table#estimate-table tbody").append(markup);
                        count = count + 1;
                        i = i + 1;
                    });
                })
            }
        });
    </script>
@endpush
