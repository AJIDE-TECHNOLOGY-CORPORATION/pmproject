@extends('layouts.customer-layout')
@section('title', 'Invoice')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ __('all.invoices') }}</h1>
                        </div>
                        <div class="col-6 col-auto">
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6 text-right">
                                    <a class="btn btn-primary btn-sm print text-white" target="_blank">Print</a>
                                    <a class="btn btn-success btn-sm pdf text-white" target="_blank">Download Pdf</a>
                                    @if($invoice->invoice_status!=1)
                                        @php
                                            $email = base64_encode((Session::has('email')) ? Session::get('email') : "");
                                            $id = base64_encode($invoice->id);
                                        @endphp
                                            <input type="hidden" name="payment_id" value="{{ $email }}"/>
                                            <input type="hidden" name="payment_email" value="{{ $id }}"/>
                                        @if((getStripeStatus()=='1') || (getRazorpayStatus()=='1') || (getPaypalStatus()=='1'))
                                            <a class="btn btn-dark btn-sm text-white" data-toggle="modal" data-target="#paymentModalCenter">Pay Now</a>
                                        @endif
                                    @endif

                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-new-color1">
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
                            <input type="hidden" value="{{ $invoice->id }}" name="invoiceId" id="invoiceId"/>
                            <div class="table-responsive push">
                                <table class="table table-bordered table-hover text-nowrap" id="invoice-table">
                                    <tr class=" ">
                                        <th>{{ __('all.product') }}</th>
                                        <th class="text-center">{{ __('all.qty') }}</th>
                                        <th class="text-right">{{ __('all.unit_price') }} ({{ $currency }})</th>
                                        <th class="text-right">{{ __('all.amount') }} ({{ $currency }})</th>
                                    </tr>
                                </table>
                                <input type="hidden" name="tax_rate" id="tax_rate"/>
                                <input type="hidden" name="tax_name" id="tax_name"/>
                                <input type="hidden" name="tax_percentage" id="tax_percentage"/>
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
                                                    <td class="text-right text-primary">
                                                        <h5> {{ $invoice->total }} </h5>
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
    <div class="modal fade" id="paymentModalCenter" tabindex="-1" role="dialog" aria-labelledby="paymentModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Choose Payment Gateway</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container text-center">
                    @if(getStripeStatus()=='1')
                        <button type="button" class="btn stripe-bg btn-md stripe"><i class="fab fa-stripe-s"></i>  Stripe</button>
                    @endif
                        @if(getPaypalStatus()=='1')
                            <button type="button" class="btn paypal-bg btn-md paypal"><i class="fab fa-paypal"></i>  Paypal</button>
                        @endif
                        @if(getRazorpayStatus()=='1')
                            <button type="button" class="btn razorpay-bg btn-md razorpay"><i class="fas fa-rupee-sign"></i>  Razorpay</button>
                            @endif
</div>
</div>
</div>
</div>
</div>

@endsection
@push('js')
<script>
$(document).ready(function () {
'use strict';
var i = 0,
payable = 0;
/* to load already available invoice items */
var invoiceId = $('#invoiceId').val();
if (invoiceId != "") {
/* if the invoice is non empty */
var url = "{{ url('customer/invoices/get-invoice-product') }}" + '/' + invoiceId;
var count = 0;
$.get(url, function (data) {
$.each(data.data, function (key) {
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
/* pdf section */
$(document).ready(function () {
$(".pdf").on('click', function () {
'use strict';
var query = {
id: $("input[name='invoice_id']").val(),
}
var url = "{{url('customer/invoices/downloadPdf')}}?" + $.param(query)
window.location = url;
});
});
</script>

<script>
/* print section */
$(document).ready(function () {
$(".print").on('click', function () {
'use strict';
$('.hidden_div').hide();
window.print();
});
});
</script>

<script>
/* stripe section */
$(document).ready(function () {
$(".stripe").on('click', function () {
'use strict';
var id = $("input[name='payment_id']").val();
var email = $("input[name='payment_email']").val();

var url = "{{ url('/customer/invoices/stripe-payment') }}"+"/"+email+"/"+id
window.location = url;
});
});
</script>
<script>
    /* razorpay section */
    $(document).ready(function () {
        $(".razorpay").on('click', function () {
            'use strict';
            var id = $("input[name='payment_id']").val();
            var email = $("input[name='payment_email']").val();

            var url = "{{ url('/customer/invoices/razorpay-payment') }}"+"/"+email+"/"+id
            window.location = url;
        });
    });
</script>
<script>
    /* paypal section */
    $(document).ready(function () {
        $(".paypal").on('click', function () {
            'use strict';
            var id = $("input[name='payment_id']").val();
            var email = $("input[name='payment_email']").val();

            var url = "{{ url('/customer/invoices/paypal') }}"+"/"+email+"/"+id
            window.location = url;
        });
    });
</script>
@endpush
