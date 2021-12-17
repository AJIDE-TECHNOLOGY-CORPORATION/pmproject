@extends('layouts.admin-layout')
@section('title', 'Invoice Report')
@section('content')
    <div class="content p-3">
        <section class="content">
            <div class="card card-outline shadow-3">
                <div class="card-header admin-cart-header">
                    <h3 class="card-title">{{ __('all.invoice_report') }}</h3>
                </div>
                <div class="card-body pb-0 shadow-3">
                    <div class="row">
                        @php
                            $customers = App\Customer::latest()->get();
                        @endphp

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('all.choose_duration') }}</label>
                                <select class="form-control select2" name="report_by" id="report_by">
                                    <option value="">--{{ __('all.choose_duration') }}--</option>
                                    <option value="1">{{ __('all.today') }}</option>
                                    <option value="2">{{ __('all.this_week') }}</option>
                                    <option value="3">{{ __('all.this_month') }}</option>
                                    <option value="4">{{ __('all.this_year') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('all.from_date') }}</label>
                                <input type="date" name="from_date" c class="form-control" placeholder="Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('all.to_date') }}</label>
                                <input type="date" name="to_date" class="form-control" placeholder="Invoice Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('all.show_records') }}</label>
                                <select class="custom-select sort-list col-sm-2">
                                    <option value="5" {{ $options['limit'] == 10 ? 'selected' : '' }}>5
                                    </option>
                                    <option value="10" {{ $options['limit'] == 50 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="all" {{ $options['limit'] == 'all' ? 'selected' : 'selected' }}>
                                        All
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data-list">
                @include('admin.reports.invoice-report-list')
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        (function ($) {
            'use strict';
            $(document).on('change', "input[name='from_date']", function (event) {
                'use strict';
                $('#report_by').val('');
                loadInvoices(1);
            });
            $(document).on('change', "input[name='to_date']", function (event) {
                'use strict';
                $('#report_by').val('');
                loadInvoices(1);
            });
            $(document).on('change', '.sort-list', function (event) {
                'use strict';
                loadInvoices(1);
            });
            $(document).on('change', '#report_by', function (event) {
                'use strict';
                $("input[name='from_date']").val('');
                $("input[name='to_date']").val('')
                loadInvoices(1);
            });
            $(document).on('click', 'a.page-link', function (event) {
                'use strict';
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadInvoices(page);
            });
        })(jQuery);

        function loadInvoices(page) {
            'use strict';
            var limit = $(".sort-list option:selected").val();
            var report_by = $('#report_by').val();
            var from_date = $("input[name='from_date']").val();
            var to_date = $("input[name='to_date']").val();
            getInvoiceData(page, from_date, to_date, limit, report_by);
        }

        /* load the content dependds on selection */
        function getInvoiceData(page, from_date, to_date, limit, report_by) {
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('admin/reports/invoice') }}?page=" + page + "&report_by=" +
                    report_by + "&from_date=" + from_date + "&to_date=" + to_date + "&limit=" + limit,
                success: function (data) {
                    $('.data-list').html('');
                    $('.data-list').html(data);
                }
            })
        }
    </script>
@endpush
