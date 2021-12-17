@extends('layouts.customer-layout')
@section('title','Dashboard')
@push('js')
    <script src="{{asset('assets/backend/plugins/chart.js/Chart.min.js')}}"></script>
@endpush
@section('content')
    @php
        $settings = new App\MasterSetting();
        $site = $settings->siteData();
        $currency = ($site['default_currency'] && $site['default_currency']) !=""? $site['default_currency'] : '₹';
        $customer_id = (Session::has('id')) ? Session::get('id') : "";
    @endphp

    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 ">
                    <div class="info-box shadow-3">
                        <span class="info-box-icon custom-widget-1"><i class="fas fa-receipt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{__('all.today_invoice')}}</span>
                            <span class="info-box-number"> {{$currency}} {{App\Invoice::where('invoice_date',\Carbon\Carbon::today())->where('customer_id',$customer_id)->sum('total')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-3">
                        <span class="info-box-icon custom-widget-2"><i class="fas fa-receipt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{__('all.this_month_total_invoice')}}</span>
                            <span class="info-box-number"> {{$currency}} {{App\Invoice::whereBetween('invoice_date',[\Carbon\Carbon::now()->startOfMonth(),\Carbon\Carbon::now()->endOfMonth()])->where('customer_id',$customer_id)->sum('total')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-3">
                        <span class="info-box-icon custom-widget-3"><i class="fas fa-wallet"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{__('all.today_payment')}}</span>
                            <span class="info-box-number">{{$currency}}  {{App\Invoice::where('invoice_date',\Carbon\Carbon::today())->where('customer_id',$customer_id)->sum('paid')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-3">
                        <span class="info-box-icon custom-widget-4"><i class="fas fa-wallet"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{__('all.this_month_total_payment')}}</span>
                            <span class="info-box-number">{{$currency}}  {{App\Invoice::whereBetween('invoice_date',[\Carbon\Carbon::now()->startOfMonth(),\Carbon\Carbon::now()->endOfMonth()])->where('customer_id',$customer_id)->sum('paid')}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-new-color1 shadow-3">
                        <div class="card-header">
                            <h3 class="card-title">{{__('all.revenue_comparison')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="invoice-status-chart" class="h-300 chartjs-render-monitor" width="541" height="300">
                                </canvas>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-new-color1 shadow-3">
                        <div class="card-header">
                            <h3 class="card-title">{{__('all.expenses')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="customer-expense-chart" class="h-300 chartjs-render-monitor" width="541"
                                        height="300"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-new-color1 shadow-3">
                        <div class="card-header">
                            <h3 class="card-title">{{__('all.recent_invoice')}}</h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                @php
                                    $invoices = App\Invoice::where('customer_id',$customer_id)->latest()->limit(5)->get();
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
                                                            <a class="btn-link"
                                                               href="{{url('customer/invoices/show/'.$row->id)}}">{{$row->invoice_number}}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> {{$row->total - $row->tax_amount}}</td>
                                                <td>{{$row->paid}}</td>
                                                <td>
                                                    @if($row->invoice_status == 1)
                                                        <span class="badge badge-pill badge-success">{{__('all.paid')}}</span>
                                                    @elseif($row->paid != 0)
                                                        <span class="badge badge-pill badge-primary">{{__('all.partially_paid')}}</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">{{__('all.pending')}}</span>
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
                    <div class="card card-outline card-new-color1 shadow-3">
                        <div class="card-header">
                            <h3 class="card-title">{{__('all.recent_payments')}}</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $payments = App\Payment::where('customer_id',$customer_id)->latest()->limit(5)->get();
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
    </div>
@endsection
@push('js')
    <script>
        /* Invoice and Expense*/
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
                        'rgb(248,205,117)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(243,167,33)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
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
    <script>
        /* customer status chart */
        "use strict";
        var cDataExpense = JSON.parse(`<?php echo $chart_data_expense; ?>`);
        var ctxExpense = document.getElementById('customer-expense-chart').getContext('2d');
        var myChartExpense = new Chart(ctxExpense, {
            type: 'pie',
            data: {
                labels: cDataExpense.label,
                datasets: [{
                    label: 'Expense',
                    data: cDataExpense.data,
                    backgroundColor: [
                        'rgb(248,205,117)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(250,186,67)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
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
