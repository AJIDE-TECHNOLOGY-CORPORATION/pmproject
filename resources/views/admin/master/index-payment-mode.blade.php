@extends('layouts.admin-layout')
@section('title', 'Payment mode')
@section('content')

    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.payment_modes') }}</h3>
                                    <button type="button" class="btn admin-submit-btn-grad float-right" data-toggle="modal"
                                            data-target="#PaymentModeModel"><i class="fa fa-plus"></i>{{ __('all.add_new_payment_mode') }}</button>
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
                                                @if (count($payment_modes) > 0)
                                                    @foreach ($payment_modes as $row)
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
                                                                    <a data-payment_mode_id="{{ $row->id }}"
                                                                        class="editPaymentMode btn btn-sm admin-submit-btn-grad text-white editItem"
                                                                        type="button"><i class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/masters/payment-mode/delete/' . $row->id) }}"
                                                                        class="delete-btn btn btn-sm btn-danger admin-delete-rigt"
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
                                @if (count($payment_modes) > 0)
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <nav>
                                                    <ul class="pagination justify-content-end">
                                                        {!! $payment_modes->links() !!}
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
    <div class="modal fade" id="PaymentModeModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.add_payment_mode') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="MyPaymentModeForm" enctype='multipart/form-data'>
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.name') }}</label>
                                        <input type="text" class="form-control mb-4" placeholder="Name"
                                            name="payment_mode_name" id="payment_mode_name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullName">{{ __('all.description') }}</label>
                                        <textarea type="text" class="form-control mb-4" name="payment_mode_description"
                                            id="payment_mode_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm add_payment_mode">{{ __('all.add') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="PaymentModeEditModel" class="modal animated zoomInUp custo-zoomInUp  mt-5" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.edit_payment_mode') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="MyPaymentModeEditForm" enctype='multipart/form-data'>
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label for="profession">{{ __('all.name') }}</label>
                                        <input type="hidden" name="payment_mode_id" id="payment_mode_id" />
                                        <input type="text" class="form-control mb-4" placeholder="Name"
                                            name="payment_mode_edit_name" id="payment_mode_edit_name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullName">{{ __('all.description') }}</label>
                                        <textarea type="text" class="form-control mb-4" name="payment_mode_edit_description"
                                            id="payment_mode_edit_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm edit_payment_mode">{{ __('all.update') }}</button>
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
            /* payment mode add */
            "use strict";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click", ".add_payment_mode", function(event) {
                'use strict';
                event.preventDefault();
                if ($('#payment_mode_name').val() == '') {
                    alert("please enter payment mode");
                    return false;
                }
                $.ajax({
                    url: "{{ url('admin/masters/payment-mode/') }}",
                    data: $('#MyPaymentModeForm').serialize(),
                    type: "POST",
                    success: function(data) {

                        if (data == "error") {
                            swal("Failure!", "Name already Taken.", "error");
                        } else {
                            $('#MyPaymentModeForm').trigger("reset");
                            $('#PaymentModeModel').modal('hide')
                            swal({
                                    title: "Success!",
                                    text: "Payment Mode added Successfully.!",
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
        $('body').on('click', '.editPaymentMode', function() {
            'use strict';
            var id = $(this).data('payment_mode_id');
            var url = "{{ url('admin/masters/payment-mode/update') }}" + '/' + id;
            $.get(url, function(data) {
                $('#PaymentModeEditModel').modal('show');
                $('#payment_mode_edit_name').val(data.data.name);
                $('#payment_mode_edit_description').val(data.data.description);
                $('#payment_mode_id').val(data.data.id);
            })
        });
    </script>
    <script>
        /* update payment mode*/
        $(document).on("click", ".edit_payment_mode", function(event) {
            'use strict';
            event.preventDefault();
            var id = $('#payment_mode_id').val();
            if ($('#payment_mode_edit_name').val() == '') {
                alert("please enter payment mode name");
                return false;
            }
            $.ajax({
                url: "{{ url('admin/masters/payment-mode/update') }}" + '/' + id,
                data: $('#MyPaymentModeEditForm').serialize(),
                type: "POST",
                success: function(data) {
                    if (data == "error") {
                        swal("Failure!", "Name already Taken.", "error");
                    } else {
                        $('#MyPaymentModeEditForm').trigger("reset");
                        $('#PaymentModeEditModel').modal('hide')
                        swal({
                                title: "Success!",
                                text: "Payment Mode Updated Successfully.!",
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
