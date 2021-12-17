@extends('layouts.admin-layout')
@section('title', 'Estimates')
@section('content')

    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.estimates') }}</h3>
                                    <a href="{{ url('admin/estimates/create') }}"
                                       class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i>{{ __('all.add_new_estimate') }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">
                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('all.estimate') }}</th>
                                                    <th>{{ __('all.bill_to') }}</th>
                                                    <th>{{ __('all.generate_date') }}</th>
                                                    <th>{{ __('all.total') }}</th>
                                                    <th>{{ __('all.options') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    @if (count($estimates) > 0)
                                                        @foreach ($estimates as $row)
                                                            <td class="align-middle">
                                                                <div class="d-flex">
                                                                    <div class="mt-1">
                                                                        <a class="admin-text-black"
                                                                           href="{{ url('admin/estimates/show/' . $row->id) }}">{{ $row->estimate_number }}</a>
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
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="{{ url('admin/estimates/show/' . $row->id) }}"
                                                                       class="btn btn-sm admin-submit-btn-grad text-white"><i
                                                                            class="fas fa-eye"></i></a>
                                                                    <a href="{{ url('admin/estimates/update/' . $row->id) }}"
                                                                       class="btn btn-sm admin-submit-btn-grad text-white"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/estimates/delete/' . $row->id) }}"
                                                                       class="delete-btn btn btn-sm btn-danger admin-delete-rigt"><i
                                                                            class="fas fa-trash"></i></a>
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
