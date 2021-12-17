@extends('layouts.admin-layout')
@section('title', 'Orders')
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
                                    <h3 class="card-title">{{ __('all.orders') }}</h3>

                                </div>
                                <div class="card-body">
                            <div class="e-table">
                                <div class="table-responsive table-lg">
                                    <table class="table card-table table-vcenter text-nowrap border mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('all.order') }}</th>
                                                <th>{{ __('all.order_from') }}</th>
                                                <th>{{ __('all.generate_date') }}</th>
                                                <th>{{ __('all.total') }}</th>
                                                <th>{{ __('all.status') }}</th>
                                                <th>{{ __('all.options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($orders) > 0)
                                                @foreach ($orders as $row)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <div class="mt-1">
                                                                    <a class="admin-text-black"
                                                                        href="{{ url('admin/orders/show/' . $row->id) }}">{{ $row->order_number }}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap align-middle"><span
                                                                class="font-weight-bold">{{ $row->customer->display_name }}</span>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ dateFormat($row->order_date) }}</span></td>
                                                        <td class="text-nowrap align-middle">{{ $row->total }}</td>
                                                        <td>
                                                            @if ($row->order_status == 1)
                                                                <span
                                                                    class="badge badge-pill badge-dark text-white">{{ __('all.accepted') }}</span>

                                                            @elseif($row->order_status == 2)
                                                                <span
                                                                    class="badge badge-pill badge-dark text-danger">{{ __('all.rejected') }}</span>
                                                            @elseif($row->order_status == 0)
                                                                <span
                                                                    class="badge badge-pill badge-dark text-warning">{{ __('all.pending') }}</span>
                                                            @elseif($row->order_status == 3)
                                                                <span
                                                                    class="badge badge-pill badge-dark text-success">{{ __('all.delivered') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ url('admin/orders/show/' . $row->id) }}"
                                                                     class="btn btn-sm admin-submit-btn-grad text-white"><i class="fas fa-eye"></i></a>

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
                        @if (count($orders) > 0)
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <nav>
                                            <ul class="pagination justify-content-end">
                                                {!! $orders->links() !!}
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
