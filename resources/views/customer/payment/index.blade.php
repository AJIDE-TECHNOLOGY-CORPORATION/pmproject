@extends('layouts.customer-layout')
@section('title', 'Payments')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ __('all.payments') }}</h1>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline card-new-color1">
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">
                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('all.payment_number') }}</th>
                                                        <th>{{ __('all.payment_date') }}</th>
                                                        <th>{{ __('all.invoice_no') }}</th>
                                                        <th>{{ __('all.payment_mode') }}</th>
                                                        <th>{{ __('all.amount') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payments as $row)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class="d-flex">
                                                                    <div class="mt-1">
                                                                        {{ $row->payment_number }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ dateFormat($row->paid_date) }}</span>
                                                            </td>
                                                            <td class="text-nowrap align-middle">
                                                                {{ $row->invoice_number }}</td>
                                                            <td class="text-nowrap align-middle">{{ $row->payment_mode }}
                                                            </td>
                                                            <td class="text-nowrap align-middle">{{ $row->paid }}</td>
                                                         
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @if (count($payments) > 0)
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <nav>
                                                    <ul class="pagination justify-content-end">
                                                        {!! $payments->links() !!}
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