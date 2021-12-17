@extends('layouts.admin-layout')
@section('title', 'Todo')
@section('content')

<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.todos') }}</h3>
                                    <a href="{{ url('admin/todos/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                                            class="fa fa-plus"></i>{{ __('all.add_new_todo') }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="e-table">
                                        <div class="table-responsive table-lg">
                                            <table class="table card-table table-vcenter text-nowrap border mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('all.title') }}</th>
                                                        <th>{{ __('all.due_date') }}</th>
                                                        <th>{{ __('all.status') }}</th>
                                                        <th>{{ __('all.completed_at') }}</th>
                                                        <th>{{ __('all.description') }}</th>
                                                        <th class="text-right">{{ __('all.options') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($todos as $row)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class="d-flex">
                                                                    <div class="mt-1">
                                                                        {{ $row->title }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ dateFormat($row->due_date) }}</span></td>
                                                            <td class="text-nowrap align-middle">
                                                                @if($row->status==0)
                                                                    <a href="#" class="btn btn-sm btn-dark text-danger change-status" data-id="{{ $row->id }}">Not Completed</a>
                                                                @else
                                                                    <a href="#" class="btn btn-sm btn-dark text-white change-status" data-id="{{ $row->id }}">Completed</a>
                                                                @endif
                                                                    </td>
                                                            <td class="text-nowrap align-middle">{{ ($row->completed_at=="") ? '-' : dateFormat($row->completed_at)}}</td>
                                                            <td class="text-nowrap align-middle">{{ ($row->description)}}</td>
                                                            <td class="text-nowrap align-right text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{ url('admin/todos/update/' . $row->id) }}"
                                                                    class="btn btn-sm admin-submit-btn-grad text-white editItem"
                                                                        type="button"><i class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/todos/delete/' . $row->id) }}"
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
                                        @if (count($todos) > 0)
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <nav>
                                                            <ul class="pagination justify-content-end">
                                                                {!! $todos->links() !!}
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

@push('js')
<script>
/* change active and inactive status */
$(document).on("click", ".change-status", function () {
var id = $(this).data('id');
         if (id) {
            $.ajax({
                url: "{{ url('admin/todos/change-status/') }}",
                data: {
                    id : id
                },
                type: "GET",

                success: function (data) {
                   location.reload();
                }
            });
        }
    });
</script>
@endpush
