@extends('layouts.admin-layout')
@section('title', 'Expense Category')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.expense_category') }}</h3>
                                    <button type="button" class="btn admin-submit-btn-grad float-right" data-toggle="modal"
                                            data-target="#ExpenseCategoryModel"><i class="fa fa-plus"></i>{{ __('all.add_new_expense_category') }}</button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-bordered border-top text-nowrap dataTable no-footer"
                                               id="example1" role="grid" aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="border-bottom-0 w-20 sorting">{{ __('all.name') }}
                                                </th>
                                                <th class="border-bottom-0 w-30 sorting">{{ __('all.description') }}
                                                </th>
                                                <th class="border-bottom-0 w-10 sorting">{{ __('all.actions') }}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($expense_categories) > 0)
                                                @foreach ($expense_categories as $row)
                                                    <tr role="row" class="odd">
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <div class="ml-3 mt-1">
                                                                    <h6 class="mb-0 font-weight-bold">
                                                                        {{ $row->name }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->description }}</span></td>
                                                        <td class="align-middle">
                                                            <div class="btn-group align-top">
                                                                <a data-id="{{ $row->id }}"
                                                                   class="editExpenseCategory btn btn btn-sm admin-submit-btn-grad text-white"
                                                                   type="button"><i class="fas fa-edit"></i></a>

                                                                <a href="{{ url('admin/masters/expense-category/delete/' . $row->id) }}"
                                                                   class="delete-btn btn btn-sm btn-danger  admin-delete-rigt"
                                                                   type="button"><i class="fas fa-trash"></i></a>
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
                            @if (count($expense_categories) > 0)
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <nav>
                                                <ul class="pagination justify-content-end">
                                                    {!! $expense_categories->links() !!}
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
    <div class="modal fade" id="ExpenseCategoryModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.add_expense_category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="MyExpenseCategoryForm" enctype='multipart/form-data'>
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.name') }}</label>
                                        <input type="text" class="form-control mb-4" placeholder="Name"
                                               name="expense_category_name" id="expense_category_name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullName">{{ __('all.description') }}</label>
                                        <textarea type="text" class="form-control mb-4" name="description"
                                                  id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm add_expense_category">{{ __('all.add') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="ExpenseCategoryEditModel" class="modal animated zoomInUp custo-zoomInUp  mt-5" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.edit_expense_category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="MyExpenseCategoryEditForm" enctype='multipart/form-data'>
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.name') }}</label>
                                        <input type="hidden" name="id" id="id" />
                                        <input type="text" class="form-control mb-4" placeholder="Name"
                                               name="expense_category_edit_name" id="expense_category_edit_name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullName">{{ __('all.description') }}</label>
                                        <textarea type="text" class="form-control mb-4"
                                                  name="expense_category_edit_description"
                                                  id="expense_category_edit_description"></textarea>

                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button
                                    class="btn admin-submit-btn-grad btn-sm edit_expense_category">{{ __('all.update') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            "use strict";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click", ".add_expense_category", function(event) {
                'use strict';
                event.preventDefault();
                if ($('#expense_category_name').val() == '') {
                    alert("please enter expense category name");
                    return false;
                }
                $.ajax({
                    url: "{{ url('admin/masters/expense-category/') }}",
                    data: $('#MyExpenseCategoryForm').serialize(),
                    type: "POST",
                    success: function(data) {
                        if (data == "error") {
                            swal("Failure!", "Name already Taken.", "error");
                        } else {
                            $('#MyExpenseCategoryForm').trigger("reset");
                            $('#ExpenseCategoryModel').modal('hide')
                            swal("Success!", "Expense category added successfully.", "success");
                            window.location.reload();
                        }
                    }
                })
            })
        });
    </script>
    <script>
        /* edit Expense Category */
        $('body').on('click', '.editExpenseCategory', function() {
            'use strict';
            var id = $(this).data('id');
            var url = "{{ url('admin/masters/expense-category/update') }}" + '/' + id;
            $.get(url, function(data) {
                $('#ExpenseCategoryEditModel').modal('show');
                $('#expense_category_edit_name').val(data.data.name);
                $('#expense_category_edit_description').val(data.data.description);
                $('#id').val(data.data.id);
            })
        });
    </script>
    <script>
        /* update expense category */
        $(document).on("click", ".edit_expense_category", function(event) {
            'use strict';
            event.preventDefault();
            var id = $('#id').val();
            if ($('#expense_category_edit_name').val() == '') {
                alert("please enter expense category name");
                return false;
            }
            $.ajax({
                url: "{{ url('admin/masters/expense-category/update') }}" + '/' + id,
                data: $('#MyExpenseCategoryEditForm').serialize(),
                type: "POST",
                success: function(data) {
                    if (data == "error") {
                        swal("Failure!", "Name already Taken.", "error");
                    } else {
                        $('#MyExpenseCategoryEditForm').trigger("reset");
                        $('#ExpenseCategoryEditModel').modal('hide')
                        swal({
                            title: "Success!",
                            text: "Expense category updated Successfully.!",
                            icon: "success",
                        })
                            .then((isConfirm) => {
                                if (isConfirm) {
                                    window.location.reload();
                                }
                            });
                    }
                }
            });
        });
    </script>
@endpush
