@extends('layouts.customer-layout')
@section('title', 'Edit Profile')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            @php
              $customer_id = base64_encode($customer->id);
            @endphp
            <form
                action="{{ isset($customer) ? url('customer/edit-profile/'.$customer_id) : '' }}"
                method="post" id="MyCustomerEditProfileForm" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card card-outline card-new-color1">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('all.basic_info') }}</h3>
                            </div>
                            <div class="card-body">

                            <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.upload_photo') }}:</label>
                                            <input type="file" class="dropify"
                                                data-default-file="{{ !empty($customer->avatar) && File::exists('uploads/customer/' . $customer->avatar) ? asset('uploads/customer/' . $customer->avatar) : asset('uploads/customer/default.png') }}"
                                                data-max-file-size="2M" name="avatar"
                                                data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG"
                                                accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="200"
                                                data-show-remove="false" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.display_name') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name"
                                                id="display_name" name="display_name"
                                                value="{{ isset($customer) ? $customer->display_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.primary_contact_name') }}</label>
                                            <input type="text" class="form-control mb-4" id="contact_name"
                                                name="contact_name"
                                                value="{{ isset($customer) ? $customer->contact_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.email') }}</label>
                                            <input type="text" class="form-control mb-4 check-email" id="email"
                                                name="email"
                                                value="{{ isset($customer) ? $customer->email : '' }}">
                                                <b><span id="email_status" class="text-danger"></span></b>
                                        </div>
                                    </div>

                                    @if(isset($user))
                                        <input type="hidden" class="form-control" id="flag" name="flag" value="1">
                                        <input type="hidden" class="form-control" id="id" name="id" value="{{isset($customer) ? $customer->id : '0'}}">
                                    @else
                                        <input type="hidden" class="form-control" id="flag" name="flag" value="0">
                                    @endif

                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.password') }}</label>
                                            <input type="password" class="form-control mb-4" id="password" name="password" value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.phone_number') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="phone" name="phone"
                                                value="{{ isset($customer) ? $customer->phone : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.primary_currency') }}</label>
                                            @php
                                                $currencies = App\Currency::get();
                                            @endphp
                                            <select name="currency" id="currency" class="form-control select2"
                                                data-placeholder="Choose one (with searchbox)">
                                                <option value="">--{{ __('all.choose_currency') }}--</option>
                                                @foreach ($currencies as $row)
                                                    <option value="{{ $row->code }}"
                                                        {{ isset($customer) && $customer->currency == $row->code ? 'selected' : '' }}>
                                                        {{ $row->code }}
                                                        ({{ $row->name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.website') }}</label>
                                            <input type="text" class="form-control mb-4" id="website" name="website"
                                                value="{{ isset($customer) ? $customer->website : '' }}">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card card-outline card-new-color1">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('all.billing_address') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.name') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name"
                                                id="billing_address_name" name="billing_address_name"
                                                value="{{ isset($customer) ? $customer->billing_address_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.phone_number') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="billing_address_phone"
                                                name="billing_address_phone"
                                                value="{{ isset($customer) ? $customer->billing_address_phone : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.country') }}</label>
                                            @php
                                                $countries = App\Country::get();
                                            @endphp
                                            <select class="form-control select2"
                                                data-placeholder="Choose one (with searchbox)"
                                                name="billing_address_country" id="billing_address_country">
                                                @foreach ($countries as $row)
                                                    <option value="">--{{ __('all.choose_country') }}--</option>
                                                    <option value="{{ $row->country_code }}"
                                                        {{ isset($customer) && $customer->billing_address_country == $row->country_code ? 'selected' : '' }}>
                                                        {{ $row->country_code }}
                                                        ({{ $row->country_name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.state') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="billing_address_state"
                                                name="billing_address_state"
                                                value="{{ isset($customer) ? $customer->billing_address_state : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.city') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="billing_address_city"
                                                name="billing_address_city"
                                                value="{{ isset($customer) ? $customer->billing_address_city : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.zip_code') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="billing_address_zip"
                                                name="billing_address_zip"
                                                value="{{ isset($customer) ? $customer->billing_address_zip : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address_1') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea type="text" class="form-control mb-4" id="billing_address1"
                                                name="billing_address1">{{ isset($customer) ? $customer->billing_address1 : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address_2') }}: </label>
                                            <textarea type="text" class="form-control mb-4" id="billing_address2"
                                                name="billing_address2">{{ isset($customer) ? $customer->billing_address2 : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card card-outline card-new-color1">
                            <div class="card-header">
                                <h3 class="card-title col-md-10">{{ __('all.shipping_address') }}</h3>
                                <button type="button" class="btn btn-sm admin-submit-btn-grad col-auto float-right  address-change"><i
                                        class="fe fe-copy"></i> {{ __('all.copy_from_billing') }}
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.name') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name"
                                                id="shipping_address_name" name="shipping_address_name"
                                                value="{{ isset($customer) ? $customer->shipping_address_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.phone_number') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="shipping_address_phone"
                                                name="shipping_address_phone"
                                                value="{{ isset($customer) ? $customer->shipping_address_phone : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.country') }}</label>
                                            @php
                                                $countries = App\Country::get();
                                            @endphp
                                            <select class="form-control select2"
                                                data-placeholder="Choose one (with searchbox)"
                                                name="shipping_address_country" id="shipping_address_country">
                                                <option value="">--{{ __('all.choose_country') }}--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->country_code }}"
                                                        {{ isset($customer) && $customer->shipping_address_country == $row->country_code ? 'selected' : '' }}>
                                                        {{ $row->country_code }}
                                                        ({{ $row->country_name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.state') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="shipping_address_state"
                                                name="shipping_address_state"
                                                value="{{ isset($customer) ? $customer->shipping_address_state : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.city') }}:<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="shipping_address_city"
                                                name="shipping_address_city"
                                                value="{{ isset($customer) ? $customer->shipping_address_city : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.zip_code') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="shipping_address_zip"
                                                name="shipping_address_zip"
                                                value="{{ isset($customer) ? $customer->shipping_address_zip : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address_1') }}:<span
                                                    class="text-red">*</span></label>
                                            <textarea type="text" class="form-control mb-4" id="shipping_address1"
                                                name="shipping_address1">{{ isset($customer) ? $customer->shipping_address1 : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.address_2') }}:</label>
                                            <textarea type="text" class="form-control mb-4" id="shipping_address2"
                                                name="shipping_address2">{{ isset($customer) ? $customer->shipping_address2 : '' }}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-footer mt-2">
                                            <button class="btn btn-primary" type="submit">{{ __('all.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')

    <script>
        /* copy billing address to shipping address */
        $(document).on("click", ".address-change", function(event) {
            'use strict';
            $("#shipping_address1").val($('#billing_address1').val());
            $("#shipping_address2").val($('#billing_address2').val());
            $("#shipping_address_state").val($('#billing_address_state').val());
            $("#shipping_address_city").val($('#billing_address_city').val());
            $("#shipping_address_country").val($('#billing_address_country').val()).trigger('change');
            $("#shipping_address_phone").val($('#billing_address_phone').val());
            $("#shipping_address_name").val($('#billing_address_name').val());
            $("#shipping_address_zip").val($('#billing_address_zip').val());
        });
    </script>

<script>
   
   /* check email uniqueness */
   $(document).on("keyup", ".check-email", function () {
  'use strict';
 
          var email=$("#email" ).val();
          var flag=$('#flag').val();
          var id=$('#id').val();
          if(email)
          {
              $.ajax({
                  type: 'post',
                  url: '{{ url('/customer/checkEmail') }}',
                  data: {
                      user_email:email,
                      flag:flag,
                      id:id,
                      "_token": "{{ csrf_token() }}",
                  },
                  dataType: 'json',
                  success: function (response) {
                      if(response=="OK")
                      {
                          $('#email_status').html("");
                          $('.next_btn').prop('disabled',false);
                          return true;
                      }
                      else
                      {
                          $( '#email_status' ).html(response);
                          $('#email').focus();
                          $('.next_btn').prop('disabled',true);
                          return false;
                      }
                  }
              });
          }

      });
</script>

@endpush