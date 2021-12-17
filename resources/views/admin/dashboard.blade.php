@extends('layouts.admin-layout')
@section('title','Dashboard')
@push('js')
    <script src="{{asset('assets/backend/plugins/chart.js/Chart.min.js')}}"></script>
@endpush
@section('content')
    @php
        $settings = new App\MasterSetting();
        $site = $settings->siteData();
        $currency = ($site['default_currency'] && $site['default_currency']) !=""? $site['default_currency'] : '₹';
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-receipt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.today_invoice')}}</span>
                        <span
                            class="info-box-number"> {{$currency}} {{App\Invoice::where('invoice_date',\Carbon\Carbon::today())->sum('total')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-receipt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.this_month_total_invoice')}}</span>
                        <span
                            class="info-box-number"> {{$currency}} {{App\Invoice::whereBetween('invoice_date',[\Carbon\Carbon::now()->startOfMonth(),\Carbon\Carbon::now()->endOfMonth()])->sum('total')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-wallet"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.today_payment')}}</span>
                        <span
                            class="info-box-number">{{$currency}}{{App\Invoice::where('invoice_date',\Carbon\Carbon::today())->sum('paid')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-wallet"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.this_month_total_payment')}}</span>
                        <span
                            class="info-box-number">{{$currency}}  {{App\Invoice::whereBetween('invoice_date',[\Carbon\Carbon::now()->startOfMonth(),\Carbon\Carbon::now()->endOfMonth()])->sum('paid')}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline shadow-3">
                    <div class="card-header admin-cart-header">
                        <h3 class="card-title">{{__('all.revenue_comparison')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-wrapper-demo">
                            <canvas id="invoice-status-chart" class="h-300 chartjs-render-monitor" width="541"
                                    height="300">
                            </canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline shadow-3">
                    <div class="card-header admin-cart-header">
                        <h3 class="card-title">{{__('all.expenses')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-wrapper-demo">
                            <canvas id="customer-status-chart" class="h-300 chartjs-render-monitor" width="541"
                                    height="300"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline shadow-3">
                    <div class="card-header admin-cart-header">
                        <h3 class="card-title">{{__('all.recent_invoice')}}</h3>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            @php
                                $invoices = App\Invoice::latest()->limit(5)->get();
                            @endphp
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="th-content">{{__('all.date')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.invoice')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.customer')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.total')}}({{$currency}})</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.paid')}}({{$currency}})</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.status')}}</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($invoices)>0)
                                    @foreach($invoices as $row)
                                        <tr>
                                            <td>{{dateFormat($row->invoice_date)}}</td>
                                            <td class="align-middle">
                                                <div class="d-flex">
                                                    <div class="mt-1">
                                                        <a class="admin-text-black"
                                                           href="{{url('admin/invoices/show/'.$row->id)}}">{{$row->invoice_number}}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$row->customer->display_name}}</td>
                                            <td> {{$row->total - $row->tax_amount}}</td>
                                            <td>{{$row->paid}}</td>
                                            <td>
                                                @if($row->invoice_status == 1)
                                                    <span
                                                        class="badge badge-pill admin-black text-success">{{__('all.paid')}}</span>
                                                @elseif($row->paid != 0)
                                                    <span
                                                        class="badge badge-pill admin-black text-primary">{{__('all.partially_paid')}}</span>
                                                @else
                                                    <span
                                                        class="badge badge-pill admin-black text-white">{{__('all.pending')}}</span>
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
            </div>
            <div class="col-md-6">
                <div class="card card-outline shadow-3">
                    <div class="card-header admin-cart-header">
                        <h3 class="card-title">{{__('all.recent_payments')}}</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $payments = App\Payment::latest()->limit(5)->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="th-content">{{__('all.date')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.payment_number')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.invoice')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.customer')}}</div>
                                    </th>
                                    <th>
                                        <div class="th-content">{{__('all.amount')}}({{$currency}})</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $row)
                                    <tr>
                                        <td>{{dateFormat($row->paid_date)}}</td>
                                        <td>{{$row->payment_number }}</td>
                                        <td>{{$row->invoice_number }}</td>
                                        <td>{{$row->customer->display_name}}</td>
                                        <td>{{$row->paid}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script>
        /* Income and Espense*/
        "use strict";
        var cDataInvoice = JSON.parse(`<?php echo $chart_data_invoice; ?>`);
        var ctxInvoice = document.getElementById('invoice-status-chart').getContext('2d');
        var myChartInvoice = new Chart(ctxInvoice, {
            type: 'bar',
            data: {
                labels: cDataInvoice.label,
                datasets: [{
                    label: 'Invoice and Expense',
                    data: cDataInvoice.data,
                    backgroundColor: [
                        'rgb(38,38,38)',
                        'rgb(62,62,62)',
                        'rgb(108,117,125)',
                        'rgb(206,212,218)',
                        'rgb(222,226,230)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(0,0,0)',
                        'rgb(50,50,50)',
                        'rgb(33,37,41)',
                        'rgb(52,58,64)',
                        'rgb(73,80,87)',
                        'rgb(0,0,0)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        /* expense chart */
        "use strict";
        var cDataExpense = JSON.parse(`<?php echo $chart_data_expense; ?>`);
        var ctxExpense = document.getElementById('customer-status-chart').getContext('2d');
        var myChartCustomer = new Chart(ctxExpense, {
            type: 'pie',
            data: {
                labels: cDataExpense.label,
                datasets: [{
                    label: 'Expenses',
                    data: cDataExpense.data,
                    backgroundColor: [
                        'rgb(38,38,38)',
                        'rgb(62,62,62)',
                        'rgb(108,117,125)',
                        'rgb(206,212,218)',
                        'rgb(222,226,230)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(0,0,0)',
                        'rgb(50,50,50)',
                        'rgb(33,37,41)',
                        'rgb(52,58,64)',
                        'rgb(73,80,87)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
