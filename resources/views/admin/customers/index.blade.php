@extends('layouts.admin-layout')
@section('title', 'Customers')
@section('content')
    <div class="content p-3">
        <section class="content">
            <div class="card card-outline shadow-3">
                <div class="card-header admin-cart-header">
                    <h3 class="card-title">{{ __('all.customers') }}</h3>
                    <a href="{{ url('admin/customers/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                            class="fa fa-plus"></i>{{ __('all.add_new_customer') }}</a>
                </div>
                <div class="card-body pb-0 shadow-3">
                    <div class="row">
                        @if (count($customers) > 0)
                            @foreach ($customers as $row)
                                <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch flex-column">
                                    <div class="card admin-customer-card-bg-1 d-flex flex-fill">
                                        <div class="card-header text-white admin-border-bottom-1">
                                          <strong>{{ $row->display_name }}</strong>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h6>{{ $row->contact_name }}</h6><br>
                                                    <ul class="ml-4 mb-0 fa-ul text-white pt-2">
                                                         <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> {{ __('all.email') }}: {{ $row->email }}</li>
                                                        <br>
                                                         <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> {{ __('all.phone_number') }} #: {{ $row->phone }}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-5 text-center">
                                                    <img src="{{ !empty($row->avatar) && File::exists('uploads/customer/' . $row->avatar) ? asset('uploads/customer/' . $row->avatar) : asset('uploads/customer/default.png') }}" alt="user-avatar" class="img-circle img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer admin-customer-cardfooter-bg-1">
                                            <div class="text-right">
                                                <a href="{{ url('admin/customers/update/' . $row->id) }}" class="btn btn-sm bg-white">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('admin/customers/delete/' . $row->id) }}" class="delete-btn btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @if (count($customers) > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <nav>
                                    <ul class="pagination justify-content-end">
                                        {!! $customers->links() !!}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
