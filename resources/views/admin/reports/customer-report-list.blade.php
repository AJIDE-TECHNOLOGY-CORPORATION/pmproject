@php
$settings = new App\MasterSetting();
$site = $settings->siteData();
$currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
@endphp
@if (!empty($customer))
    <div class="card card-outline card-dark shadow-3">
        <div class="card-body">
            <p class="h5 font-weight-bold">{{ __('all.customer') }}</p>
            <address>
                Name: <strong>{{ $customer->display_name }}</strong><br>
                Address: <strong>{{ $customer->billing_address1 }}</strong><br>
                City: <strong>{{ $customer->billing_address_city }}</strong><br>
                Phone: <strong>{{ $customer->billing_address_phone }}</strong>
            </address>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0 " width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('all.paid_amount') }} ({{ $currency }})</th>
                            <th> {{ __('all.invoice_amount') }} ({{ $currency }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ __('all.paid') }}</td>
                            <td> {{ $customer->invoiceDetails()->sum('paid') }} </td>
                            <td></td>
                        </tr>
                        <td> {{ __('all.invoice_amount') }}</td>
                        <td></td>
                        <th> {{ $customer->invoiceDetails()->sum('total') }} </th>
                        </tr>
                        </tr>
                    </tbody>
                    <tfoot>
                    <td colspan="2" class="text-center text-danger"> <strong> {{ __('all.balance') }}({{ $currency }}) </strong>
                        </td>
                        <td class="text-danger"> <strong>
                            {{ $customer->invoiceDetails()->sum('total') - $customer->invoiceDetails()->sum('paid') }}
                            </strong>
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif
