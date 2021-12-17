@extends('layouts.admin-layout')
@section('title', 'Tax Types')
@section('content')
<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.tax_types') }}</h3>
                                    <button type="button" class="btn admin-submit-btn-grad float-right" data-toggle="modal"
                                     data-target="#TaxModel"><i class="fa fa-plus"></i>{{ __('all.add_new_tax') }}</button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-bordered border-top text-nowrap dataTable no-footer"
                                            id="example1" role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="border-bottom-0 w-20 sorting">{{ __('all.name') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-15 sorting">{{ __('all.percentage') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-30 sorting">{{ __('all.description') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-10 sorting">{{ __('all.actions') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($taxes as $row)
                                                    <tr role="row" class="odd">
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <div class="ml-3 mt-1">
                                                                    <h6 class="mb-0 font-weight-bold">{{ $row->name }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->percentage }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->description }}</span></td>
                                                        <td class="align-middle">
                                                            <div class="btn-group align-top">
                                                                <a data-tax_id="{{ $row->id }}"
                                                                class="btn btn-sm admin-submit-btn-grad text-white editTax"
                                                                        type="button"><i class="fas fa-edit"></i></a>
                                                                <a href="{{ url('admin/masters/tax/delete/' . $row->id) }}"
                                                                    class="delete-btn btn btn-sm btn-danger admin-delete-rigt"
                                                                    type="button"><i class="fas fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if (count($taxes) > 0)
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <nav>
                                                <ul class="pagination justify-content-end">
                                                    {!! $taxes->links() !!}
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
    <div class="modal fade" id="TaxModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.add_tax') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="MyTaxForm" enctype='multipart/form-data'>
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.name') }}</label>
                                        <input type="text" class="form-control mb-4" placeholder="Name" name="tax_name"
                                            id="tax_name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.percentage') }}</label>
                                        <input type="text" class="form-control mb-4" placeholder="Percentage"
                                            name="tax_percentage" id="tax_percentage">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullName">{{ __('all.description') }}</label>
                                        <textarea type="text" class="form-control mb-4" name="tax_description"
                                            id="tax_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm add_tax">{{ __('all.add') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="TaxEditModel" class="modal animated zoomInUp custo-zoomInUp  mt-5" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.edit_tax') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="MyTaxEditForm" enctype='multipart/form-data'>
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.name') }}</label>
                                        <input type="hidden" name="tax_id" id="tax_id" />
                                        <input type="text" class="form-control mb-4" placeholder="Name" name="tax_edit_name"
                                            id="tax_edit_name">

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.percentage') }}</label>
                                        <input type="text" class="form-control mb-4" placeholder="Percentage"
                                            name="tax_edit_percentage" id="tax_edit_percentage">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullName">{{ __('all.description') }}</label>
                                        <textarea type="text" class="form-control mb-4" name="tax_edit_description"
                                            id="tax_edit_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary btn-sm edit_tax">{{ __('all.update') }}</button>
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
            /* tax add */
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click", ".add_tax", function(event) {
                'use strict';
                event.preventDefault();
                if ($('#tax_name').val() == '') {
                    alert("please enter tax name");
                    return false;
                }
                if ($('#tax_percentage').val() == '') {
                    alert("please enter tax percentage name");
                    return false;
                }
                if (isNaN($('#tax_percentage').val())) {
                    alert("please enter valid tax percentage.");
                    return false;
                }
                if (isNaN($('#tax_percentage').val() == '')) {
                    alert("please provide a valid number");
                    return false;
                }
                $.ajax({
                    url: "{{ url('admin/masters/tax/') }}",
                    data: $('#MyTaxForm').serialize(),
                    type: "POST",
                    success: function(data) {
                        if (data == "error") {
                            swal("Failure!", "Name already Taken.", "error");
                        } else {
                            $('#MyTaxForm').trigger("reset");
                            $('#TaxModel').modal('hide')
                            swal({
                                    title: "Success!",
                                    text: "Tax added Successfully.!",
                                    icon: "success",
                                })
                                .then((isConfirm) => {
                                    if (isConfirm) {
                                        window.location.reload();
                                    }
                                });
                        }
                    }
                })
            })
        });
    </script>
    <script>
        /* edit Tax */
        $('body').on('click', '.editTax', function() {
            'use strict';
            var id = $(this).data('tax_id');
            var url = "{{ url('admin/masters/tax/update') }}" + '/' + id;
            $.get(url, function(data) {
                $('#TaxEditModel').modal('show');
                $('#tax_edit_name').val(data.data.name);
                $('#tax_edit_percentage').val(data.data.percentage);
                $('#tax_edit_description').val(data.data.description);
                $('#tax_id').val(data.data.id);
            })
        });
    </script>
    <script>
        /* update tax */
        $(document).on("click", ".edit_tax", function(event) {
            'use strict';
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $('#tax_id').val();
            if ($('#tax_edit_name').val() == '') {
                alert("please enter tax name");
                return false;
            }
            if ($('#tax_edit_percentage').val() == '') {
                alert("please enter tax percentage.");
                return false;
            }

            if (isNaN($('#tax_edit_percentage').val())) {
                alert("please enter valid tax percentage.");
                return false;
            }

            if (isNaN($('#tax_edit_percentage').val())) {
                alert("please enter a valid number.");
                return false;
            }
            $.ajax({
                url: "{{ url('admin/masters/tax/update') }}" + '/' + id,
                data: $('#MyTaxEditForm').serialize(),
                type: "POST",
                success: function(data) {
                    if (data == "error") {
                        swal("Failure!", "Name already Taken.", "error");
                    } else {
                        $('#MyTaxEditForm').trigger("reset");
                        $('#TaxEditModel').modal('hide')
                        swal({
                                title: "Success!",
                                text: "Tax updated Successfully.!",
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
