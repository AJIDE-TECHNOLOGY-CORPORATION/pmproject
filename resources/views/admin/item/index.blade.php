@extends('layouts.admin-layout')
@section('title', 'Items')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.items') }}</h3>
                                    <button type="button" class="btn btn-xs admin-submit-btn-grad float-right" data-toggle="modal"
                                            data-target="#ItemModel"><i class="fa fa-plus"></i>{{ __('all.add_new_item') }}</button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-bordered border-top text-nowrap dataTable no-footer"
                                            id="example1" role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="border-bottom-0 w-20 sorting">{{ __('all.image') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-20 sorting">{{ __('all.name') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-15 sorting">{{ __('all.unit') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-30 sorting">{{ __('all.price') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-30 sorting">{{ __('all.description') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-30 sorting">{{ __('all.created_at') }}
                                                    </th>
                                                    <th class="border-bottom-0 w-10 sorting">{{ __('all.actions') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($items) > 0)
                                                    @foreach ($items as $row)
                                                        <tr role="row" class="odd">
                                                            <td class="align-middle">
                                                                <img src="{{(!empty($row->image) && File::exists('uploads/items/'.$row->image)) ? asset('uploads/items/'.$row->image):asset('uploads/items/default.png') }}" height="50" width="50"/>
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="d-flex">
                                                                    <div class="ml-3 mt-1">
                                                                        <h6 class="mb-0 font-weight-bold">
                                                                            {{ $row->name }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ $row->unit }}</span></td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ $row->price }}</span></td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ $row->description }}</span></td>
                                                            <td class="text-nowrap align-middle">
                                                                <span>{{ dateFormat($row->created_at) }}</span></td>
                                                            <td class="align-middle">
                                                                <div class="btn-group align-top">
                                                                    <a data-item_id="{{ $row->id }}"
                                                                        class="btn btn-sm admin-submit-btn-grad text-white editItem"
                                                                        type="button"><i class="fas fa-edit"></i></a>
                                                                    <a href="{{ url('admin/items/delete/' . $row->id) }}"
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
                                @if (count($items) > 0)
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <nav>
                                                    <ul class="pagination justify-content-end">
                                                        {!! $items->links() !!}
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
    <div id="ItemModel" class="modal animated zoomInUp custo-zoomInUp  mt-5" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.add_items') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <form id="MyItemForm">
                            {{ @csrf_field() }}
                            <div class="form">

                                <div class="form-group ">
                                <input type="file" class="dropify"
                                       data-default-file="{{ asset('uploads/items/default.png') }}"
                                       data-max-file-size="2M" name="image" id="image"
                                       data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG"
                                       accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="200"
                                       data-show-remove="false"/>
                                </div>
                                <div class="form-group ">
                                    <label for="profession">{{ __('all.name') }}</label>
                                    <input type="text" class="form-control mb-4" name="name" id="name">
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullName">{{ __('all.price') }}</label>
                                            <input type="text" class="form-control mb-4" name="price" id="price">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullName">{{ __('all.unit') }}</label>
                                            <input type="text" class="form-control mb-4" name="unit" id="unit">
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
                            </div>
                            <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm add-item">{{ __('all.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ItemEditModel" class="modal animated zoomInUp custo-zoomInUp  mt-5" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.edit_items') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <form id="MyItemEditForm">
                            {{ @csrf_field() }}
                            <div class="form">
                                <div class="form-group image_show">

                                </div>
                                <div class="form-group ">
                                    <label for="profession">{{ __('all.name') }}</label>
                                    <input type="text" class="form-control mb-4" name="edit_name" id="edit_name">
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullName">{{ __('all.price') }}</label>
                                            <input type="text" class="form-control mb-4" name="edit_price" id="edit_price">
                                            <input type="hidden" name="item_id" id="item_id" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullName">{{ __('all.unit') }}</label>
                                            <input type="text" class="form-control mb-4" name="edit_unit" id="edit_unit">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullName">{{ __('all.description') }}</label>
                                            <textarea type="text" class="form-control mb-4" name="edit_description"
                                                id="edit_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm update-item">{{ __('all.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            /* item add */
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click", ".add-item", function(event) {
                'use strick';
                event.preventDefault();
                if ($('#name').val() == '') {
                    alert("please enter name");
                    return false;
                }
                if ($('#unit').val() == '') {
                    alert("please enter units");
                    return false;
                }
                if ($('#price').val() == '') {
                    alert("please enter price.");
                    return false;
                }
                if (isNaN($('#price').val())) {
                    alert("please enter a valid price.");
                    return false;
                }


                var postData = new FormData($("#MyItemForm")[0]);

                $.ajax({
                    url: "{{ url('admin/items/') }}",
                    data: postData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: "POST",

                    success: function(data) {
                        if (data == "error") {
                            swal("Failure!", "Name already Taken.", "error");
                        } else {
                            $('#MyItemForm').trigger("reset");
                            $('#ItemModel').modal('hide')
                            swal({
                                    title: "Success!",
                                    text: "Items added Successfully.!",
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
        /* edit item */
        $('body').on('click', '.editItem', function() {
            'use strick';
            var id = $(this).data('item_id');
            var url = "{{ url('admin/items/update') }}" + '/' + id;
            $.get(url, function(data) {
                $('#ItemEditModel').modal('show');
                $('#edit_name').val(data.data.name);
                $('#edit_price').val(data.data.price);
                $('#edit_unit').val(data.data.unit);
                $('#edit_description').val(data.data.description);
                $('#item_id').val(data.data.id);
                   var nameImage = "{{ asset('uploads/items') }}" + '/' + data.data.image;
                    var $html = '<input type="file" class="dropify edit_image" data-default-file="' + nameImage + '" data-max-file-size="2M" name="edit_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="200"  data-show-remove="false"/>';
                $('.image_show').html($html);
                $('.edit_image').dropify();

                            })
        });
    </script>
    <script>
        /* update payment mode*/
        $(document).on("click", ".update-item", function(event) {
            'use strict';
            event.preventDefault();
            var id = $('#item_id').val();
            if ($('#edit_name').val() == '') {
                alert("please enter name");
                return false;
            }
            if ($('#edit_unit').val() == '') {
                alert("please enter units");
                return false;
            }
            if ($('#edit_price').val() == '') {
                alert("please enter price.");
                return false;
            }
            if (isNaN($('#edit_price').val())) {
                alert("please enter a valid price.");
                return false;
            }
            var postData = new FormData($("#MyItemEditForm")[0]);
            $.ajax({
                url: "{{ url('admin/items/update') }}" + '/' + id,
                data: postData,
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",

                success: function(data) {
                    if (data == "error") {
                        swal("Failure!", "Name already Taken.", "error");
                    } else {
                        $('#MyItemEditForm').trigger("reset");
                        $('#ItemEditModel').modal('hide')
                        swal({
                                title: "Success!",
                                text: "Item Updated Successfully.!",
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
