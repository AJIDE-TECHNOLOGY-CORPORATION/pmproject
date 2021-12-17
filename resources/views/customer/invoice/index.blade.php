@extends('layouts.customer-layout')
@section('title', 'Invoices')
@section('content')

    <div class="content p-3">
        <div class="container-fluid">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ __('all.invoices') }}</h1>
                        </div>

                    </div>
                </div>
            </section>
            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="card card-outline card-new-color1">
                        <div class="card-body">
                            <div class="e-table">
                                <div class="table-responsive table-lg">
                                    <table class="table card-table table-vcenter text-nowrap border mb-0">
                                        <thead>
                                        <tr>
                                            <th>{{ __('all.invoice') }}</th>
                                            <th>{{ __('all.bill_to') }}</th>
                                            <th>{{ __('all.generate_date') }}</th>
                                            <th>{{ __('all.due_date') }}</th>
                                            <th>{{ __('all.sub_total') }}</th>
                                            <th>{{ __('all.tax') }}</th>
                                            <th>{{ __('all.total') }} ({{ getCurrency()}})</th>
                                            <th>{{ __('all.paid') }} ({{ getCurrency()}}) </th>
                                            <th>{{ __('all.status') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (count($invoices) > 0)
                                            @foreach ($invoices as $row)
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="d-flex">
                                                            <div class="mt-1">
                                                                <a class="btn-link"
                                                                   href="{{ url('customer/invoices/show/' . $row->id) }}">{{ $row->invoice_number }}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap align-middle"><span
                                                            class="font-weight-bold">{{ $row->customer->display_name }}</span>
                                                    </td>
                                                    <td class="text-nowrap align-middle">
                                                        <span>{{ dateFormat($row->invoice_date) }}</span></td>
                                                    <td class="text-nowrap align-middle">
                                                        <span>{{ ($row->due_date!='')?dateFormat($row->due_date):'' }}</span></td>
                                                    <td class="text-nowrap align-middle">
                                                        {{ $row->total - $row->tax_amount }}</td>
                                                    <td class="text-nowrap align-middle"> {{ $row->tax_amount }}</td>
                                                    <td class="text-nowrap align-middle">{{ $row->total }}</td>
                                                    <td class="text-nowrap align-middle">{{ $row->paid }}</td>
                                                    <td>
                                                        @if ($row->invoice_status == 1)
                                                            <span
                                                                class="badge badge-pill badge-success">{{ __('all.paid') }}</span>
                                                        @elseif($row->paid != 0)
                                                            <span
                                                                class="badge badge-pill badge-primary">{{ __('all.partially_paid') }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-pill badge-warning">{{ __('all.pending') }}</span>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if (count($invoices) > 0)
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <nav>
                                            <ul class="pagination justify-content-end">
                                                {!! $invoices->links() !!}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
