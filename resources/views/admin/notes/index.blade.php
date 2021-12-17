@extends('layouts.admin-layout')
@section('title', 'Notes')
@section('content')
<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.notes') }}</h3>
                                    <a href="{{ url('admin/notes/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i> {{ __('all.add_new_note') }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">

                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('all.title') }}</th>
                                                        <th>{{ __('all.subject') }}</th>
                                                        <th>{{ __('all.notes') }}</th>
                                                        <th class="text-right">{{ __('all.options') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($notes as $row)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class="d-flex">
                                                                    <div class="mt-1">
                                                                        {{ $row->title }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ $row->subject }}</span></td>
                                                            <td class="text-nowrap align-middle">{{ $row->note }}</td>
                                                            <td class="text-nowrap align-right text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{ url('admin/notes/update/' . $row->id) }}"
                                                                    class="btn btn-sm admin-submit-btn-grad text-white"><i class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/notes/delete/' . $row->id) }}"
                                                                    class="delete-btn btn btn-sm btn-danger admin-delete-rigt"><i class="fas fa-trash"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if (count($notes) > 0)
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <nav>
                                                            <ul class="pagination justify-content-end">
                                                                {!! $notes->links() !!}
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
        </div>
    </div>
@endsection
