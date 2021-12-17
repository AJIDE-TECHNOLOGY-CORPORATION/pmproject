@extends('layouts.customer-layout')
@section('title', 'Estimates')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ __('all.estimates') }}</h1>
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
                                                        <th>{{ __('all.estimate') }}</th>
                                                        <th>{{ __('all.bill_to') }}</th>
                                                        <th>{{ __('all.generate_date') }}</th>
                                                        <th>{{ __('all.total') }} ({{getCurrency()}})</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @if (count($estimates) > 0)
                                                            @foreach ($estimates as $row)
                                                                <td class="align-middle">
                                                                    <div class="d-flex">
                                                                        <div class="mt-1">
                                                                            <a class="btn-link"
                                                                                href="{{ url('customer/estimates/show/' . $row->id) }}">{{ $row->estimate_number }}</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-nowrap align-middle"><span
                                                                        class="font-weight-bold">{{ $row->customer->display_name }}</span>
                                                                </td>
                                                                <td class="text-nowrap align-middle">
                                                                    <span>{{ dateFormat($row->estimate_date) }}</span></td>
                                                                <td class="text-nowrap align-middle">
                                                                    {{ $row->total }}
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
                            @if (count($estimates) > 0)
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <nav>
                                                <ul class="pagination justify-content-end">
                                                    {!! $estimates->links() !!}
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
@endsection