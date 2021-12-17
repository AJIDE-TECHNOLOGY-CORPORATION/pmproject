@extends('layouts.admin-layout')
@section('title', 'Order')
@push('css')
<link href="{{ asset('assets/common/mail_button.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.orders') }}</h3>
                                    @if(($order->order_status==3) && ($order->invoice_status==0))
                                    <a class="btn btn-primary btn-sm convert_to_invoice text-white float-right" target="_blank">Convert to Invoice</a>
                                    @endif
                                </div>
                                <div class="card-body">
                            <div class="row pt-4">
                                <div class="col-lg-6 ">
                                    <p class="h5 font-weight-bold">{{ __('all.order_from') }}</p>
                                    {{ $order->customer->display_name }}
                                    <address>
                                        {{ $order->customer->billing_address1 }}<br>
                                        {{ $order->customer->billing_state }}<br>
                                        {{ $order->customer->billing_zip }}<br>
                                        {{ $order->customer->phone }}
                                    </address>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <h2 class="font-weight-bold">{{ __('all.order') }}</h2>
                                    <span>{{ __('all.order_no') }}:</span>
                                    <strong>{{ $order->order_number }}</strong>
                                    <br>
                                    <span>{{ __('all.order_date') }}:</span>
                                    <strong>{{ dateFormat($order->order_date) }}</strong>
                                    <br/>
                                    @if($order->invoice_status==1)
                                    <span>{{ __('all.invoice_no') }}:</span>
                                    <strong>{{ $order->invoice->invoice_number }}</strong>
                                        @endif
                                </div>
                            </div>
                            @php
                                $settings = new App\MasterSetting();
                                $site = $settings->siteData();
                                $customers = App\Customer::latest()->get();
                                $products = App\Item::where('is_active', 1)->get();
                                $currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
                            @endphp
                            <input type="hidden" value="{{ $order->id }}" name="orderId" id="orderId" />
                                    <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}"/>
                            <div class="table-responsive push">
                                <table class="table table-bordered table-hover text-nowrap" id="order-table">
                                    <tr class=" ">
                                        <th>{{ __('all.product') }}</th>
                                        <th class="text-center">{{ __('all.qty') }}</th>
                                        <th class="text-right">{{ __('all.unit_price') }}</th>
                                        <th class="text-right">{{ __('all.amount') }}</th>
                                    </tr>
                                </table>

                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="form-label">{{ __('all.status') }}</label>
                                                <select class="form-control select2"
                                                        data-placeholder="Choose one (with searchbox)"
                                                        name="order_status" id="order_status">
                                                    @if(($order->order_status!=3))
                                                            <option value="0" {{ ($order->order_status==0) ? 'selected' : '' }}>{{ __('all.pending') }}</option>
                                                            <option value="1" {{ ($order->order_status==1) ? 'selected' : '' }}>{{ __('all.accepted') }}</option>
                                                            <option value="2" {{ ($order->order_status==2) ? 'selected' : '' }}>{{ __('all.rejected') }}</option>
                                                    @endif
                                                    <option value="3" {{ ($order->order_status==3) ? 'selected' : '' }}>{{ __('all.delivered') }}</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6 ">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border ">
                                            <table class="table mb-0 ">

                                                <tr>
                                                    <th>{{ __('all.total') }}:{{ $currency }} </th>
                                                    <td class="text-right text-dark">
                                                        <h4><strong>{{ $order->total }}</strong></h4>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                   </div>
                        </div>
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
            /* to load already available order items */
            var orderId = $('#orderId').val();
            if (orderId != "") {
                /* if the order is non empty */
                var url = "{{ url('admin/orders/get-order-product') }}" + '/' + orderId;
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
                        $("table#order-table tbody").append(markup);
                        count = count + 1;
                        i = i + 1;
                    });
                })
            }
        });
    </script>

    <script>
        /* order status change */

        $('select[name="order_status"]').on('change', function () {
            var orderStatus = $(this).val();
            var orderId = $('#order_id').val();
            if (orderStatus) {
                $.ajax({
                    url: "{{ url('admin/orders/change-order-status') }}",
                    data: {
                        order_status: orderStatus,
                        order_id: orderId,
                    },
                    type: "GET",

                    success: function (data) {
                        location.reload();
                    }
                });
            }
        });


    </script>

    <script>
        /* convert to invoice */
        $(document).ready(function()
        {
            $(".convert_to_invoice").on('click',function()
            {
                'use strict';
                var query = {
                    id:$('#order_id').val(),
                }
                var url = "{{url('admin/orders/convert_to_invoice')}}?" + $.param(query)
                window.location = url;
            });
        });

    </script>
@endpush
