@extends('layouts.admin-layout')
@section('title', 'Accounts')
@section('content')
<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.accounts') }}</h3>
                                    <a href="{{ url('admin/bank/accounts/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i> {{ __('all.add_new_account') }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">
                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('all.name') }}</th>
                                                    <th>{{ __('all.bank') }}</th>
                                                    <th>{{ __('all.account_number') }}</th>
                                                    <th>{{ __('all.current_balance') }}</th>
                                                    <th>{{ __('all.address') }}</th>
                                                    <th class="text-right">{{ __('all.options') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($accounts as $row)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <div class="mt-1">
                                                                    {{ $row->name }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->bank_name }}</span></td>
                                                        <td class="text-nowrap align-middle">{{ $row->account_number }}
                                                        </td>
                                                        <td class="text-nowrap align-middle">{{ $row->balance }}</td>
                                                        <td class="text-nowrap align-middle">{{ $row->bank_address }}</td>
                                                        <td class="text-nowrap align-right text-right">
                                                            <div class="btn-group">
                                                                <a href="{{ url('admin/bank/accounts/update/' . $row->id) }}"
                                                                    class="btn btn-sm admin-submit-btn-grad text-white"><i class="fas fa-edit"></i></a>
                                                                <a href="{{ url('admin/bank/accounts/delete/' . $row->id) }}"
                                                                    class="delete-btn btn btn-sm btn-danger text- admin-delete-rigt"><i class="fas fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             </div>
                                    @if (count($accounts) > 0)
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">
                                                    <nav>
                                                        <ul class="pagination justify-content-end">
                                                            {!! $accounts->links() !!}
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
