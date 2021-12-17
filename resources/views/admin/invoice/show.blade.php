@extends('layouts.admin-layout')
@section('title', 'Invoice')
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
                                    <h3 class="card-title">{{ __('all.invoices') }}</h3>

                                    <div class="row" class="hidden_div">
                                        <div class="col-md-6">

                                        </div>

                                    </div>
                                    <div class="col-md-6 text-right">

                                    </div>
                                    <div class="float-right">
                                        <a class="btn btn-primary btn-sm print text-white" target="_blank">Print</a>
                                        <a class="btn btn-success btn-sm pdf text-white" target="_blank">Download Pdf</a>
                                       @if($invoice->invoice_status!=1)
                                            @if((getStripeStatus()=='1') || (getRazorpayStatus()=='1') || (getPaypalStatus()=='1'))
                                                <a href="#" class="btn btn-sm btn-dark text-white" data-invoice-id="{{ $invoice->id }}" data-toggle="modal" data-target="#paymentModal">{{ __('all.send_payment_link') }}</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row pt-4">
                                        <div class="col-lg-6 ">
                                            <p class="h5 font-weight-bold">{{ __('all.bill_to') }}</p>
                                            {{ $invoice->customer->display_name }}
                                            <address>
                                                {{ $invoice->customer->billing_address1 }}<br>
                                                {{ $invoice->customer->billing_state }}<br>
                                                {{ $invoice->customer->billing_zip }}<br>
                                                {{ $invoice->customer->phone }}
                                            </address>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <h2 class="font-weight-bold">{{ __('all.invoice') }}</h2>
                                            <span>{{ __('all.invoice_no') }}:</span>
                                            <strong>{{ $invoice->invoice_number }}</strong>
                                            <br>
                                            <span>{{ __('all.invoice_date') }}:</span>
                                            <strong>{{ dateFormat($invoice->invoice_date) }}</strong>
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
                                    <input type="hidden" value="{{ $invoice->id }}" name="invoiceId" id="invoiceId" />
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}"/>
                                    <div class="table-responsive push">
                                        <table class="table table-bordered table-hover text-nowrap" id="invoice-table">
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
                                                            <th>{{ __('all.sub_total') }}:{{ $currency }} </th>
                                                            <td class="text-right">{{ $invoice->sub_total }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('all.tax') }}:{{ $currency }} <span
                                                                    class="text-regular"></span></th>
                                                            <td class="text-right"> {{ $invoice->tax_amount }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('all.total') }}:{{ $currency }} </th>
                                                            <td class="text-right text-dark">
                                                                <h4><strong>{{ $invoice->total }}</strong></h4>
                                                            </td>
                                                        </tr>
                                                    </table>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ __('all.send_payment_link') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="payment_link-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="formGroupExampleInput">{{ __('all.email') }}</label> <span
                                    class="required text-danger">*</span>
                                <input type="text" class="form-control" id="email" name="email" value=" {{ $invoice->customer->email }}" />
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $invoice->id }}" />
                                <input type="hidden" class="form-control" id="customer_name" name="customer_name" value="{{ $invoice->customer->display_name }}" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="container text-center">
                                    @if(getStripeStatus()=='1')
                                        <input type="checkbox" name="stripe" id="stripe" class="stripe">
                                        <label for="stripe">
                                            <button type="button" class="btn stripe-bg btn-md stripe"><i class="fab fa-stripe-s"></i>  Stripe</button>
                                        </label>
                                    @endif
                                    @if(getPaypalStatus()=='1')
                                            <input type="checkbox" name="paypal" id="paypal" class="paypal">
                                            <label for="paypal">
                                                <button type="button" class="btn paypal-bg btn-md paypal"><i class="fab fa-paypal"></i>  Paypal</button>
                                            </label>
                                    @endif
                                    @if(getRazorpayStatus()=='1')
                                            <input type="checkbox" name="razorpay" id="razorpay" class="razorpay">
                                            <label for="razorpay">
                                                <button type="button" class="btn razorpay-bg btn-md razorpay"><i class="fas fa-rupee-sign"></i>  Razorpay</button>
                                            </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal">{{ __('all.close') }}</button>
                            <button class="btn btn-primary send_link">{{ __('all.send') }}</button>
                        </div>
                    </form>
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
            /* to load already available invoice items */
            var invoiceId = $('#invoiceId').val();
            if (invoiceId != "") {
                /* if the invoice is non empty */
                var url = "{{ url('admin/invoices/get-invoice-product') }}" + '/' + invoiceId;
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
                        $("table#invoice-table tbody").append(markup);
                        count = count + 1;
                        i = i + 1;
                    });
                })
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /* submit the invoice */
            $(document).on("click", ".send_link", function(event) {
                'use_strict';
                event.preventDefault();
                if ($('#email').val() == '') {
                    /* if the customer is empty */
                    swal("Error!", "Please enter email to make payment.", "error");
                    return false;
                }
                var count=0;
                if($('#stripe').is(':checked')){
                    count=count+1;
                }
                if($('#paypal').is(':checked')){
                    count=count+1;
                }
                if($('#razorpay').is(':checked')){
                    count=count+1;
                }
                if(count==0) {
                    swal("Error!", "Please choose at least one payment method.", "error");
                    return false;
                }
                $.ajax({
                    url: "{{ url('admin/invoices/send-payment-link') }}",
                    method: "POST",
                    data: $('#payment_link-form').serialize(),
                    success: function(data) {
                        if(data=='success') {
                            /* link sent successfully */
                            swal({
                                title: "Success!",
                                text: "Payment Link sent successfully.",
                                icon: 'success',
                                dangerMode: true,
                                buttons: {
                                    confirm: {
                                        text: 'ok',
                                        value: true,
                                        visible: true,
                                        closeModal: true
                                    },
                                },
                            })
                                .then((isConfirm) => {
                                    if (isConfirm) {
                                        /* if the response is ok */
                                        window.location.href = "{{ url('admin/invoices/') }}";
                                    }
                                });
                        } else {
                            swal("Error!", "Something went wrong. Try again Later.", "error");
                        }
                        $('#paymentModal').modal('hide');
                    }
                });
            });
        });
    </script>


    <script>
        /* pdf section */
        $(document).ready(function()
        {
            $(".pdf").on('click',function()
            {
                'use strict';
                var query = {
                    id:$("input[name='invoice_id']").val(),
                }
                var url = "{{url('admin/invoices/downloadPdf')}}?" + $.param(query)
                window.location = url;
            });
        });
    </script>

    <script>
        /* print section */
        $(document).ready(function()
        {
            $(".print").on('click',function()
            {
                'use strict';
                $('.hidden_div').hide();
                window.print();
            });
        });
    </script>
@endpush
