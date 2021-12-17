@php
$settings = new App\MasterSetting();
$site = $settings->siteData();
$currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
@endphp
@if (count($invoices) > 0)
    <div class="card card-outline card-dark shadow-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-binvoiceed mb-0 " width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('all.invoice_id') }}</th>
                            <th>{{ __('all.date') }}</th>
                            <th>{{ __('all.name') }}</th>
                            <th>{{ __('all.sub_total') }} ({{ $currency }})</th>
                            <th>{{ __('all.tax') }} ({{ $currency }})</th>
                            <th>{{ __('all.total') }} ({{ $currency }})</th>
                            <th>{{ __('all.paid') }} ({{ $currency }})</th>
                            <th>{{ __('all.paid_status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = $invoices->firstItem();
                        @endphp
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ dateFormat($invoice->invoice_date) }}</td>
                                <td>{{ $invoice->customer ? $invoice->customer->display_name : '' }}</td>
                                <td>{{ $invoice->sub_total }}</td>
                                <td>{{ $invoice->tax_amount }}</td>
                                <td>{{ $invoice->total }}</td>
                                <td>{{ $invoice->paid }}</td>
                                <td>
                                    @if ($invoice->invoice_status == 1)
                                        <span class="badge badge-pill badge-dark text-white">{{ __('all.paid') }}</span>
                                    @elseif($invoice->paid != 0)
                                        <span
                                            class="badge badge-pill badge-dark text-primary">{{ __('all.partially_paid') }}</span>
                                    @else
                                        <span class="badge badge-pill badge-dark text-warning">{{ __('all.pending') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light text-primary font-weight-bold">
                            <td colspan="4" class="text-center">{{ __('all.total') }}</td>
                            <td>{{ $invoices->sum('sub_total') }}</td>
                            <td>{{ $invoices->sum('tax_amount') }}</td>
                            <td>{{ $invoices->sum('total') }}</td>
                            <td>{{ $invoices->sum('paid') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@else
    <p class="text-danger text-center"><strong>{{ __('all.no_record_founds') }}</strong></p>
@endif
@if (count($invoices) > 0)
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <nav>
                    <ul class="pagination justify-content-end">
                        {{ $invoices->links() }}
                    </ul>
                </nav>
            </div>
        </div>

    </div>
@endif
