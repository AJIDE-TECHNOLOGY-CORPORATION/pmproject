@extends('layouts.customer-layout')
@section('title', 'Orders')
@section('content')

    <div class="content p-3">
        <div class="container-fluid">

            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="card card-outline card-new-color1">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('all.order') }}#{{ $order->order_number }}</h3>

                        </div>
                        <div class="card-body">


                            @php
                                $settings = new App\MasterSetting();
                                $site = $settings->siteData();
                                $customers = App\Customer::latest()->get();
                                $products = App\Item::where('is_active', 1)->get();
                                $taxes = App\TaxType::where('is_active', 1)->get();
                                $currency = ($site['default_currency'] && $site['default_currency']) != '' ? $site['default_currency'] : '₹';
                            @endphp
                            <input type="hidden" value="{{ $order->id }}" name="orderId" id="orderId"/>
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <label class="font-weight-bold">{{ __('all.order_from') }}</label>
                                    <div class="billed-to">
                                        <h6><span id="customer_name">{{ $order->customer->display_name }}</span></h6>
                                        <p><span id="address"> {{ $order->customer->shipping_address1 }}</span><br>
                                            <span id="phone"></span>{{ $order->customer->phone }}<br>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <span>{{ __('all.order_date') }}:</span>
                                    <input type="date" class="form-control" placeholder="Invoice Date"
                                           name="order_date" id="order_date"
                                           value="{{ $order->order_date }}" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-new-color1">
                        <div class="card-body">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('all.choose_product') }}<span
                                            class="text-red">*</span></label>
                                    <select class="form-control select2" data-placeholder="Choose one (with searchbox)"
                                            name="item" id="item">
                                        <option value="">--{{ __('all.choose_product') }}--</option>
                                        @foreach ($products as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }} [
                                                {{ $currency }}{{ $row->price }}]
                                            </option>
                                        @endforeach
                                    </select>
                                    </select>
                                </div>
                            </div>
                            <form id="product-form">
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered border text-nowrap mb-0" id="order-table">
                                        <thead>
                                        <tr>
                                            <th class="wd-20p">{{ __('all.product') }}</th>
                                            <th class="tx-center">{{ __('all.qty') }}</th>
                                            <th class="tx-right">{{ __('all.unit_price') }}</th>
                                            <th class="tx-right">{{ __('all.amount') }}</th>
                                            @if($order->order_status !=1 )
                                                <th class="tx-right">{{ __('all.actions') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered border text-nowrap mb-0">
                                        <tbody>
                                        <tr>
                                            <td class="valign-middle" colspan="2" rowspan="4">
                                                <div class="order-notes">
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden" name="tax" id="tax"/>
                                                            <input type="hidden" name="tax_rate" id="tax_rate"/>
                                                            <input type="hidden" name="tax_name" id="tax_name"/>
                                                            <input type="hidden" name="tax_percentage"
                                                                   id="tax_percentage"/>
                                                            <input type="hidden" name="sub_total" id="sub_total"/>
                                                            <input type="hidden" name="net_total" id="net_total"/>
                                                            <input type="hidden" name="order_status" id="order_status"
                                                                   value="{{ $order->order_status }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="text-uppercase font-weight-semibold">{{ __('all.total') }}</td>
                                            <td class="tx-right">
                                                <h4 class="text-dark font-weight-bold">{{ $currency }} <b
                                                        class="net_total">0</b></h4>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="customer_id" id="customer_id"/>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary mt-4"
                                            id="submit_order">{{ __('all.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ __('all.add_quantity') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="formGroupExampleInput">{{ __('all.quantity') }}</label> <span
                                class="required text-danger">*</span>
                            <input type="text" class="form-control" id="qty" name="qty" value=""/>
                            <input type="hidden" class="form-control" id="id" name="id" value=""/>
                            <input type="hidden" class="form-control" id="name" name="name" value=""/>
                            <input type="hidden" class="form-control" id="price" name="price" value=""/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal">{{ __('all.close') }}</button>
                        <button class="btn btn-primary add_item">{{ __('all.add') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateQuantityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ __('all.edit_item') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="formGroupExampleInput">{{ __('all.quantity') }}</label> <span
                                class="required text-danger">*</span>
                            <input type="text" class="form-control" id="update_qty" name="update_qty" value=""/>
                            <input type="hidden" class="form-control" id="update_id" name="update_id" value=""/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="hidden" class="form-control" id="update_price" name="update_price" value=""/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal">{{ __('all.close') }}</button>
                        <button class="btn btn-primary update_item">{{ __('all.update') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            'use strict';
            var i = 0,
                payable = 0,
                tax_amount = 0;
            var order_status = $("#order_status").val();
            /* to load already available order items */
            var orderId = $('#orderId').val();
            if (orderId != "") {
                /* if the order is non empty */
                var url = "{{ url('customer/orders/get-order-product') }}" + '/' + orderId;
                var count = 0;
                $.get(url, function (data) {
                    $.each(data.data, function (key) {
                        var product_name = data.data[count].product_name;
                        var product_price = data.data[count].product_price;
                        var product_quantity = data.data[count].product_quantity;
                        var product_total = parseInt(data.data[count].product_quantity) *
                            parseFloat(data.data[count].product_price);
                        payable = payable + product_total;
                        if (order_status == 1) {
                            var markup = '<tr id="row' + i +
                                '" class="no"> <td class="text-left"> <h6>' + product_name +
                                '<input type="hidden" name="name[]" value="' + product_name +
                                '" readonly/></h6></td> <td class="text-dark unit"> <span class="unit_qty"> ' +
                                product_quantity +
                                '</span> <input class="qty_product" type="hidden" name="qty[]" value="' +
                                product_quantity +
                                '" readonly/></td> <td class="text-dark qty"> <span class="unit_price">' +
                                product_price +
                                '</span> <input type="hidden" class="price_product unit" name="price[]" value="' +
                                product_price +
                                '" readonly/></td> <td class="total"> <span class="unit_total"> ' +
                                product_total +
                                '</span><input type="hidden" class="total_product" name="total[]" value="' +
                                product_total +
                                '" readonly/></td></tr>';
                        } else {
                            var markup = '<tr id="row' + i +
                                '" class="no"> <td class="text-left"> <h6>' + product_name +
                                '<input type="hidden" name="name[]" value="' + product_name +
                                '" readonly/></h6></td> <td class="text-dark unit"> <span class="unit_qty"> ' +
                                product_quantity +
                                '</span> <input class="qty_product" type="hidden" name="qty[]" value="' +
                                product_quantity +
                                '" readonly/></td> <td class="text-dark qty"> <span class="unit_price">' +
                                product_price +
                                '</span> <input type="hidden" class="price_product unit" name="price[]" value="' +
                                product_price +
                                '" readonly/></td> <td class="total"> <span class="unit_total"> ' +
                                product_total +
                                '</span><input type="hidden" class="total_product" name="total[]" value="' +
                                product_total +
                                '" readonly/></td> <td class="unit"><a href="#"class="btn btn-sm btn-dark text-white btn_edit" data-update_id="' +
                                i +
                                '"> <i  class="fas fa-edit " aria-hidden="true"></i></a> <a href="#" class="delete-btn btn btn-sm btn-danger admin-delete-rigt btn_remove" data-id="' +
                                i +
                                '" > <i class="fas fa-trash del" aria-hidden="true"></i></a></td></tr>';
                        }

                        $("table#order-table tbody").append(markup);
                        count = count + 1;
                        i = i + 1;
                    });
                    tax_calculation();
                })
            }

            /* tax calculation */
            function tax_calculation() {
                'use strict';
                var tax_percentage_local = $("#tax").val();
                tax_amount = payable * (tax_percentage_local / 100.00);
                $('.net_total').html((payable + tax_amount).toFixed(2));
                $('.tax_rate').html(tax_amount.toFixed(2));
            }

            /* quantity entry */
            $('select[name="item"]').on('change', function () {
                'use strict';
                if ($('#customer').val() == '') {
                    /* if the customer is null */
                    alert("Please choose customer before make order");
                    return false;
                }
                var itemId = $(this).val();
                if (itemId != "") {
                    /* if the item is non empty */
                    var url = "{{ url('customer/orders/get-product') }}" + '/' + itemId;
                    $.get(url, function (data) {
                        $('#quantityModal').modal('show');
                        $("#qty").val('');
                        $('#name').val(data.data.name);
                        $('#price').val(data.data.price);
                        $('#id').val(data.data.id);
                    })
                }
            });
            /* tax value calculation */
            $('select[name="tax"]').on('change', function () {
                'use strict';
                $('#tax_name').val($(this).find(':selected').data('tax_name'));
                $('#tax_percentage').val($(this).find(':selected').val());
                tax_calculation();
            });

            /* add item to table */
            $(".add_item").on('click', function () {
                'use strict';
                i = i + 1;
                var qty = $("#qty").val();
                var price = $("#price").val();
                var order_status = $("#order_status").val();

                if (isNaN(qty)) {
                    /*  if the input is not a number */
                    alert("Please Provide the input as a number");
                    $("#qty").val('');
                    return false;
                }
                if (qty == "") {
                    /* if the quantity is empty */
                    alert("Please Provide a valid quantity.");
                    return false;
                }
                if (isNaN(price)) {
                    /*  if the input is not a number */
                    alert("Please Provide the input as a number");
                    $("#price").val('');
                    return false;
                }
                if (price == "") {
                    /* if the quantity is empty */
                    alert("Please Provide a valid price.");
                    return false;
                }
                var name = $("#name").val();
                var total = parseInt(qty) * parseFloat(price);
                payable = payable + total;
                if (order_status == 1) {

                    var markup = '<tr id="row' + i + '" class="no"> <td class="text-left"> <h6>' + name +
                        '<input type="hidden" name="name[]" value="' + name +
                        '" readonly/></h6></td> <td class="text-dark unit"> <span class="unit_qty"> ' + qty +
                        '</span> <input class="qty_product" type="hidden" name="qty[]" value="' + qty +
                        '" readonly/></td> <td class="text-dark qty"> <span class="unit_price">' + price +
                        '</span> <input type="hidden" class="price_product unit" name="price[]" value="' +
                        price + '" readonly/></td> <td class="total"> <span class="unit_total"> ' + total +
                        '</span><input type="hidden" class="total_product" name="total[]" value="' + total +
                        '" readonly/></td></tr>';

                } else {

                    var markup = '<tr id="row' + i + '" class="no"> <td class="text-left"> <h6>' + name +
                        '<input type="hidden" name="name[]" value="' + name +
                        '" readonly/></h6></td> <td class="text-dark unit"> <span class="unit_qty"> ' + qty +
                        '</span> <input class="qty_product" type="hidden" name="qty[]" value="' + qty +
                        '" readonly/></td> <td class="text-dark qty"> <span class="unit_price">' + price +
                        '</span> <input type="hidden" class="price_product unit" name="price[]" value="' +
                        price + '" readonly/></td> <td class="total"> <span class="unit_total"> ' + total +
                        '</span><input type="hidden" class="total_product" name="total[]" value="' + total +
                        '" readonly/></td> <td class="unit"><a href="#" class="btn btn-sm btn-dark text-white  btn_edit" data-update_id="' +
                        i +
                        '"> <i class="fas fa-edit" aria-hidden="true"></i></a> <a href="#"class="delete-btn btn btn-sm btn-danger admin-delete-rigt btn_remove" data-id="' +
                        i + '" > <i class="fas fa-trash del " aria-hidden="true"></i></a></td></tr>';
                }

                $("table#order-table tbody").append(markup);
                $('#quantityModal').modal('hide');
                $("#item").val('').trigger('change');
                tax_calculation();
            });
            /* remove product */
            $(document).on('click', '.btn_remove', function () {
                'use strict';
                swal({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    dangerMode: true,
                    buttons: {
                        confirm: {
                            text: 'Yes, delete it!',
                            value: true,
                            visible: true,
                            closeModal: true
                        },
                        cancel: {
                            text: "No, cancel please!",
                            value: false,
                            visible: true,
                            closeModal: true,
                        }
                    },
                })
                    .then((isConfirm) => {
                        if (isConfirm) {
                            /* if the response is ok */
                            var button_id = $(this).attr("data-id");
                            var price = $(this).closest("tr").find(".total_product").val();
                            $('.net_total').html(parseFloat($('.net_total').html()) - price);
                            $('.outstanding').html(parseFloat($('.outstanding').html()) - price);
                            payable = payable - price;
                            $(this).closest('tr').remove();
                            tax_calculation();
                        } else {
                            /* if the response is cancel */
                            swal("Cancelled", "Your data is safe.", "error");
                        }
                    });
            });
            /* edit quantity */
            $(document).on('click', '.btn_edit', function () {
                'use strict';
                $('#update_qty').val($(this).closest("tr").find(".qty_product").val());
                $('#update_price').val($(this).closest("tr").find(".price_product").val());
                $('#update_id').val($(this).attr('data-update_id'));
                $('#updateQuantityModal').modal('show');
            });
            /* update quantity */
            $(document).on('click', '.update_item', function () {
                'use strict';
                if (isNaN($('#update_qty').val())) {
                    /* if the quantity is not a number */
                    alert("Please Provide the input as a number.");
                    return false;
                }
                if ($('#update_qty').val() == "") {
                    /* if the quantity is null */
                    alert("Please Provide a valid quantity.");
                    return false;
                }
                if (isNaN($('#update_price').val())) {
                    /*  if the input is not a number */
                    alert("Please Provide the input as a number");
                    $('#update_price').val('');
                    return false;
                }
                if ($('#update_price').val() == "") {
                    /* if the price is empty */
                    alert("Please Provide a valid price.");
                    return false;
                }
                var button_id = $('#update_id').val();
                var total = $('#row' + button_id + '').find(".total_product").val();
                $('.net_total').html(parseFloat($('.net_total').html()) - total);
                payable = payable - total;
                var total = parseFloat($('#update_price').val()) * parseInt($('#update_qty').val());
                $('#row' + button_id + '').find(".total_product").val(total);
                $('#row' + button_id + '').find(".qty_product").val($('#update_qty').val())
                $('#row' + button_id + '').find(".price_product").val($('#update_price').val())
                $('#row' + button_id + '').find(".unit_total").html(total);
                $('#row' + button_id + '').find(".unit_qty").html($('#update_qty').val())
                $('#row' + button_id + '').find(".unit_price").html($('#update_price').val())
                $('.net_total').html(parseFloat($('.net_total').html()) + total);
                payable = payable + total;
                $('#updateQuantityModal').modal('hide');
                tax_calculation();
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /* submit the order */
            $(document).on("click", "#submit_order", function (event) {
                'use_strict';
                event.preventDefault();
                if ($('#customer').val() == '') {
                    /* if the customer is empty */
                    swal("Error!", "Please choose customer to make make order.", "error");
                    return false;
                }
                if ($('#order_date').val() == '') {
                    /* if the order date is empty */
                    swal("Error!", "Please choose order date.", "error");
                    return false;
                }

                $('#net_total').val($('.net_total').html());
                $('#sub_total').val($('.net_total').html());
                $('#tax_rate').val($('.tax_rate').html());
                $('#customer_id').val($("#customer option:selected").val());

                $(this).hide();
                var order_id = $('#orderId').val();
                $.ajax({
                    url: "{{ url('customer/orders/update') }}" + '/' + order_id,
                    method: "POST",
                    data: $('#product-form').serialize() + "&date=" + $('#order_date').val(),
                    success: function (data) {
                        /* order placed successfully */
                        swal({
                            title: "Success!",
                            text: "Order Updated Successfully.",
                            icon: 'success',
                            dangerMode: true,
                            buttons: {
                                confirm: {
                                    text: 'ok',
                                    value: true,
                                    visible: true,
                                    closeModal: true
                                },
                            },
                        })
                            .then((isConfirm) => {
                                if (isConfirm) {
                                    /* if the response is ok */
                                    window.location.href = "{{ url('customer/orders/') }}";
                                }
                            });
                    }
                });
            });
        });
    </script>
@endpush
