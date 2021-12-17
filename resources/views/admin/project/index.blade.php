@extends('layouts.admin-layout')
@section('title', 'Project')
@section('content')

<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.projects') }}</h3>
                                    <a href="{{ url('admin/projects/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i>{{ __('all.add_new_project') }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">
                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('all.customer') }}</th>
                                                        <th>{{ __('all.title') }}</th>
                                                        <th>{{ __('all.start_date') }}</th>
                                                        <th>{{ __('all.end_date') }}</th>
                                                        <th>{{ __('all.status') }}</th>
                                                        <th>{{ __('all.description') }}</th>
                                                        <th class="text-right">{{ __('all.options') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($projects as $row)
                                                        <tr>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ ($row->customer) ? $row->customer->display_name : '' }}</span></td>
                                                            <td class="align-middle">
                                                                <div class="d-flex">
                                                                    <div class="mt-1">
                                                                        {{ $row->title }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ dateFormat($row->start_date) }}</span></td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ dateFormat($row->end_date) }}</span></td>
                                                            <td class="text-nowrap align-middle">

                                                                @switch ($row->status)
                                                                    @case('0')
                                                                    <span class="badge badge-pill admin-black text-white">{{__('all.not_started')}}</span>
                                                                    @break
                                                                    @case('1')
                                                                    <span class="badge badge-pill admin-black text-warning">{{__('all.progressing')}}</span>
                                                                    @break
                                                                    @case('2')
                                                                    <span class="badge badge-pill admin-black text-danger">{{__('all.cancelled')}}</span>
                                                                    @break
                                                                    @case('3')
                                                                    <span class="badge badge-pill admin-black text-success">{{__('all.completed')}}</span>
                                                                    @break
                                                                @endswitch
                                                                    </td>
                                                            <td class="text-nowrap align-middle">{{ ($row->description)}}</td>
                                                            <td class="text-nowrap align-right text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{ url('admin/projects/update/' . $row->id) }}"
                                                                    class="btn btn-sm admin-submit-btn-grad text-white editItem"
                                                                        type="button"><i class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/projects/delete/' . $row->id) }}"
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
                                        @if (count($projects) > 0)
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <nav>
                                                            <ul class="pagination justify-content-end">
                                                                {!! $projects->links() !!}
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
