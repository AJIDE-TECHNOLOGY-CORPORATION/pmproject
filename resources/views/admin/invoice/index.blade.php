@extends('layouts.admin-layout')
@section('title', 'Invoices')
@section('content')
    @php
    $settings = new App\MasterSetting();
    $site = $settings->siteData();
    $currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
    @endphp

    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.invoices') }}</h3>
                                    <a href="{{ url('admin/invoices/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i> &nbsp; {{ __('all.add_new_invoice') }}</a>
                                </div>
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
                                                <th>{{ __('all.total') }}</th>
                                                <th>{{ __('all.paid') }}</th>
                                                <th>{{ __('all.status') }}</th>
                                                <th>{{ __('all.options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($invoices) > 0)
                                                @foreach ($invoices as $row)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <div class="mt-1">
                                                                    <a class="admin-text-black"
                                                                        href="{{ url('admin/invoices/show/' . $row->id) }}">{{ $row->invoice_number }}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap align-middle"><span
                                                                class="font-weight-bold">{{ $row->customer->display_name }}</span>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ dateFormat($row->invoice_date) }}</span></td>
                                                            <td class="text-nowrap align-middle">
                                                            <span>{{ ($row->due_date!="")? dateFormat($row->due_date) : '' }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            {{ $row->total - $row->tax_amount }}</td>
                                                        <td class="text-nowrap align-middle"> {{ $row->tax_amount }}</td>
                                                        <td class="text-nowrap align-middle">{{ $row->total }}</td>
                                                        <td class="text-nowrap align-middle">{{ $row->paid }}</td>
                                                        <td>
                                                            @if ($row->invoice_status == 1)
                                                                <span
                                                                    class="badge badge-pill badge-dark text-white">{{ __('all.paid') }}</span>
                                                            @elseif($row->paid != 0)
                                                                <span
                                                                    class="badge badge-pill badge-dark text-primary">{{ __('all.partially_paid') }}</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-pill badge-dark text-warning">{{ __('all.pending') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ url('admin/invoices/show/' . $row->id) }}"
                                                                     class="btn btn-sm admin-submit-btn-grad text-white"><i class="fas fa-eye"></i></a>
                                                                @if ($row->paid == 0)
                                                                    <!--edit and delete restricted on partial payment-->
                                                                    <a href="{{ url('admin/invoices/update/' . $row->id) }}"
                                                                         class="btn btn-sm admin-submit-btn-grad text-white"><i class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/invoices/delete/' . $row->id) }}"
                                                                      class="delete-btn btn btn-sm btn-danger admin-delete-rigt"><i class="fas fa-trash"></i></a>
                                                                @endif
                                                            </div>
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
        </div>
    </div>
@endsection
