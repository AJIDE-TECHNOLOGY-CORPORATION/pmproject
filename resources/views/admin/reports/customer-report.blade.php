@extends('layouts.admin-layout')
@section('title', 'Customer Report')
@section('content')
    <div class="content p-3">
        <section class="content">
            <div class="card card-outline shadow-3">
                <div class="card-header admin-cart-header">
                    <h3 class="card-title">{{ __('all.customer_report') }}</h3>
                </div>
                <div class="card-body pb-0 shadow-3">
                    <div class="row">
                        @php
                            $customers = App\Customer::latest()->get();
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('all.choose_customer') }}</label>
                                <select class="form-control select2" name="report_by" id="report_by">
                                    <option value="">--{{ __('all.choose_customer') }}--</option>
                                    @foreach ($customers as $row)
                                        <option value="{{ $row->id }}"> {{ $row->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data-list">
                @include('admin.reports.customer-report-list')
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        /* load the content depends on selection */
        (function ($) {
            $(document).on('change', '#report_by', function (event) {
                "use strict";
                var report_by = $('#report_by').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('admin/reports/customers') }}?report_by=" +
                        report_by,
                    success: function (data) {
                        $('.data-list').html('');
                        $('.data-list').html(data);
                    }
                })
            });
        })(jQuery);
    </script>
@endpush
