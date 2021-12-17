@extends('layouts.admin-layout')
@section('title', 'transfer')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.transfer') }}</h3>
                                    <a href="{{ url('admin/bank/transfer/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i>{{ __('all.add_new_transfer') }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">
                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                                <thead>

                                                <tr>
                                                    <th>{{ __('all.transfered_by') }}</th>
                                                    <th>{{ __('all.from_name') }}</th>
                                                    <th>{{ __('all.to_name') }}</th>
                                                    <th>{{ __('all.amount') }}</th>
                                                    <th>{{ __('all.date') }}</th>
                                                    <th>{{ __('all.reference') }}</th>
                                                    <th>{{ __('all.description') }}</th>
                                                    <th class="text-right">{{ __('all.options') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transfers as $row)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <div class="mt-1">
                                                                    {{ "admin" }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->account_from ? $row->account_from->name : '' }}</span>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            {{ $row->account_to ? $row->account_to->name : '' }}</td>
                                                        <td class="text-nowrap align-middle">{{ $row->amount }}</td>
                                                        <td class="text-nowrap align-middle">{{ dateFormat($row->date) }}
                                                        </td>
                                                        <td class="text-nowrap align-middle">{{ $row->reference }}</td>
                                                        <td class="text-nowrap align-middle">{{ $row->description }}</td>
                                                        <td class="text-nowrap align-right text-right">
                                                            <div class="btn-group">
                                                                <a href="{{ url('admin/bank/transfer/update/' . $row->id) }}"
                                                                class="btn btn-sm admin-submit-btn-grad text-white editItem"
                                                                        type="button"><i class="fas fa-edit"></i></a>
                                                                <a href="{{ url('admin/bank/transfer/delete/' . $row->id) }}"
                                                                class="delete-btn btn btn-sm btn-danger admin-delete-rigt"><i class="fas fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                    @if (count($transfers) > 0)
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">
                                                    <nav>
                                                        <ul class="pagination justify-content-end">
                                                            {!! $transfers->links() !!}
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
