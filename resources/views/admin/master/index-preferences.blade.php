@extends('layouts.admin-layout')
@section('title', 'Preferences')
@section('content')
<div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row flex-lg-nowrap">
                        <div class="col-12 mb-3">
                            <div class="card card-outline  shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.preference_settings') }}</h3>
                                </div>
                                <div class="card-body  shadow-3">
                            <form action="{{ url('admin/masters/preference/') }}" method="post" id="MyPreferenceForm"
                                enctype='multipart/form-data'>
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.currency') }}</label>
                                            @php
                                                $currencies = App\Currency::get();
                                            @endphp
                                            <select name="default_currency" id="default_currency"
                                                class="form-control select2">
                                                <option value="">--{{ __('all.choose_default_currency') }}--
                                                </option>
                                                @foreach ($currencies as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ isset($site['default_currency_code']) && !empty($site['default_currency_code']) && $site['default_currency_code'] == $row->code ? 'selected' : '' }}>
                                                        {{ $row->code }}
                                                        ({{ $row->name }})  {{ $row->symbol }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            @php
                                                $timezones = App\Timezone::Orderby('offset')->get();
                                            @endphp
                                            <label for="fullName">{{ __('all.time_zone') }}</label>
                                            <select name="default_timezone" id="default_timezone"
                                                class="form-control select2">
                                                <option value="">--{{ __('all.choose_default_timezone') }}--
                                                </option>
                                                @foreach ($timezones as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ isset($site['default_timezone']) && !empty($site['default_timezone']) && $site['default_timezone'] == $row->id ? 'selected' : ($row->name == 'Indian/Kolkata' ? 'selected' : '') }}>
                                                        {{ $row->name }}
                                                        ({{ $row->offset }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.date_format') }}</label>
                                            <select type="text" class="form-control mb-4 select2" name="default_dateformat"
                                                id="default_dateformat">
                                                <option value="">--{{ __('all.choose_date_format') }}--</option>
                                                <option value="Y-m-d"
                                                    {{ isset($site['default_dateformat']) && !empty($site['default_dateformat']) && $site['default_dateformat'] == 'Y-m-d' ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::now()->format('Y-m-d') }}</option>
                                                <option value="m/d/Y"
                                                    {{ isset($site['default_dateformat']) && !empty($site['default_dateformat']) && $site['default_dateformat'] == 'm/d/Y' ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::now()->format('m/d/Y') }}</option>
                                                <option value="d-M-Y"
                                                    {{ isset($site['default_dateformat']) && !empty($site['default_dateformat']) && $site['default_dateformat'] == 'd-M-Y' ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::now()->format('d-M-Y') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            @php
                                                $financialyears = App\FinancialYear::get();
                                            @endphp
                                            <label class="form-label">{{ __('all.settings_financial_year') }}</label>
                                            <select name="default_financialyear" id="default_financialyear"
                                                class="form-control select2" data-placeholder="Choose one (with searchbox)">
                                                <option value="">--{{ __('all.choose_default_financial_year') }}
                                                    --
                                                </option>
                                                @foreach ($financialyears as $row)
                                                    <option value="{{ $row->year }}"
                                                        {{ isset($site['default_financialyear']) && !empty($site['default_financialyear']) && $site['default_financialyear'] == $row->year ? 'selected' : '' }}>
                                                        {{ $row->duration }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-footer mt-2">
                                            <button class="btn admin-submit-btn-grad btn-sm" type="submit">{{ __('all.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
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