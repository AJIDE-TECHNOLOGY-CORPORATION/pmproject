@extends('layouts.admin-layout')
@section('title', 'Online Transaction')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.online_transaction') }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-bordered border-top text-nowrap dataTable no-footer"
                                               id="example1" role="grid" aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="border-bottom-0 w-15 sorting">{{ __('all.invoice_number') }}
                                                </th>
                                                <th class="border-bottom-0 w-30 sorting">{{ __('all.name') }}
                                                </th>
                                                <th class="border-bottom-0 w-15 sorting">{{ __('all.email') }}
                                                </th>
                                                <th class="border-bottom-0 w-10 sorting">{{ __('all.amount') }}
                                                </th>
                                                <th class="border-bottom-0 w-30 sorting">{{ __('all.payment_id') }}
                                                </th>
                                                <th class="border-bottom-0 w-30 sorting">{{ __('all.status') }}
                                                </th>
                                                <th class="border-bottom-0 w-30 sorting">{{ __('all.date') }}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($transactions) > 0)
                                                @foreach ($transactions as $row)
                                                    <tr role="row" class="odd">
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ ($row->invoice) ? $row->invoice->invoice_number : '' }}</span>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ ($row->invoice) && ($row->invoice->customer) ? $row->invoice->customer->display_name : '' }}</span>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->email }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->amount_paid }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->payment_id }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span
                                                                class="badge admin-black text-white">{{ $row->payment_status }}</span>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ dateFormat($row->date) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if (count($transactions) > 0)
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <nav>
                                                    <ul class="pagination justify-content-end">
                                                        {!! $transactions->links() !!}
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
