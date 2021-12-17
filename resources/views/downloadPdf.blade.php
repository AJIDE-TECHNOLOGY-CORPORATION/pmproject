<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .right{
            text-align:right;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
            text-align: right;
        }

        .invoice-box table tr.item td.item {
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total_first td:nth-child(3) {
            font-weight: bold;
        }
        .invoice-box table tr.total_first td:nth-child(4) {
            font-weight: bold;
        }

        .invoice-box table tr.total td:nth-child(3) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    @php
                        $settings = new App\MasterSetting();
                        $site = $settings->siteData();
                        $customers = App\Customer::latest()->get();
                        $products = App\Item::where('is_active', 1)->get();
                        $taxes = App\TaxType::where('is_active', 1)->get();
                        $currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
                    @endphp
                    <tr>
                        <td class="title">
                            <img
                                src="{{(isset($site['site_logo']) && !empty($site['site_logo']) && File::exists('uploads/logo/'.$site['site_logo'])) ? asset('uploads/logo/'.$site['site_logo']):asset('uploads/logo/logo.png')}}"
                                style="width: 100%; max-width: 300px"/>
                        </td>

                        <td>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <input type="hidden" value="{{ $invoice->id }}" name="invoiceId" id="invoiceId"/>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            <h3 class="font-weight-bold">{{ __('all.bill_to') }}</h3>
                            {{ $invoice->customer->display_name }}<br/>
                            {{ $invoice->customer->billing_address1 }}<br/>
                            {{ $invoice->customer->billing_state }} <br/>
                            {{ $invoice->customer->billing_zip }}
                        </td>
                        <td>
                            <br/> <br/>
                            {{ __('all.invoice') }}: <strong> #{{ $invoice->invoice_number }} </strong><br/>
                            {{ __('all.created') }}: <strong>{{ dateFormat($invoice->invoice_date) }} </strong><br/>
                            {{ __('all.due') }}: <strong> {{ ($invoice->due_date) ? dateFormat($invoice->due_date) :"" }} </strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    <table>
        <tbody>
        <tr class="heading">
            <td>{{ __('all.product') }}</td>
            <td>{{ __('all.unit_price') }} ({{ $currency }})</td>
            <td class="right">{{ __('all.qty') }}</td>
            <td class="right">{{ __('all.amount') }} ({{ $currency }})</td>
        </tr>
        @php
            $invoiceDetails = App\InvoiceDetails::where('invoice_id', $invoice->id)->get();
        @endphp
        @foreach($invoiceDetails as $row)
            <tr class="item">
                <td class="item"> {{ $row->product_name }} </td>
                <td> {{ $row->product_price }} </td>
                <td> {{ $row->product_quantity}} </td>
                <td> {{ $row->product_quantity *  $row->product_price}} </td>
            </tr>
        @endforeach

        <tr class="total_first">
            <td></td>  <td></td>

            <td>{{ __('all.sub_total') }}:{{ $currency }}</td><td  class="right">{{ $invoice->sub_total }}</td>
        </tr>

        <tr class="total">
            <td></td>  <td></td>

            <td>{{ __('all.tax') }}:{{ $currency }}</td><td  class="right"> {{ $invoice->tax_amount }}</td>
        </tr>

        <tr class="total">
            <td></td>  <td></td>

            <td>{{ __('all.total') }}:{{ $currency }}</td><td  class="right">  {{ $invoice->total }}</td>
        </tr>
        </tbody>
    </table>

    <br>
    <p class="text-muted text-center"><small>{{ __('all.bill_footer_msg') }}</small></p>
</div>
</body>
</html>
