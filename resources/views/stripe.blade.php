<!DOCTYPE html>
<html>
<head>
    <title>{{ __('all.stripe_payment_gateway')}}</title>
    <link rel="stylesheet" href="{{ asset('assets/common/bootstrap.min.css') }}" />
    <script src="{{asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/install/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/install/css/backend-plugin.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/install/css/backende209.css?v=1.0.0')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @php
            $settings = new App\MasterSetting();
            $site = $settings->siteData();
            $currency = ($site['default_currency'] && $site['default_currency']) !=""? $site['default_currency'] : '₹';
    @endphp

    <style type="text/css">
        .panel-title {
            display: inline;
            font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
</head>
<body>
<div class="container">
    <br><br><br><br>
    <br><br><br><br>
    <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">{{ __('all.payment_details')}}</h3>
        </div>
        <div class="card-body">
            <div class="panel-body">
                @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="{{$site['stripe_key']}}"
                      id="payment-form">
                    @csrf
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>{{ __('all.name_on_card')}}</label> <input
                                class='form-control' size='4' type='text'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>{{ __('all.card_number')}}</label> <input
                                autocomplete='off' class="form-control card-number" size="16" id="number" maxlength="19"
                                type='text'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>{{ __('all.cvc')}}</label> <input autocomplete='off'
                                                                            class='form-control card-cvc' placeholder='ex. 311' maxlength='4'
                                                                            type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>{{ __('all.expiration_month')}}</label> <input
                                class='form-control card-expiry-month' placeholder='MM' size='2' maxlength="2"
                                type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>{{ __('all.expiration_year')}}</label> <input
                                class='form-control card-expiry-year' placeholder='YYYY' size='4' maxlength='4'
                                type='text'>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'>{{ __('all.error_correction')}}</div>
                        </div>
                    </div>
                    <input type="hidden" id="amount" value="{{$invoice->total - $invoice->paid}}">
                    <input type="hidden" id="email" value="{{$email}}">
                    <input type="hidden" id="id" value="{{$invoice->id}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-warning btn-lg btn-block" type="submit">{{ __('all.pay_now')}} ({{$currency}}{{$invoice->total - $invoice->paid}})</button>
                        </div>
                    </div>
                </form>
            </div>

      </div>

    </div>
</div>
</body>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    $(function() {
        'use strict';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var $form         = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
            var $form         = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]','input[type=hidden]',
                    'textarea'].join(', '),
                $inputs       = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid         = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    /* if the input value is empty */
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });
            if (!$form.data('cc-on-file')) {
                /* stripe card creation */
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.card.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val(),
                    address_zip: $('.address_zip').val(),
                }, stripeResponseHandler);
            }
        });
        function stripeResponseHandler(status, response) {
            'use strict';
            if (response.error) {
             /* if the response has error */
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* if the response has success */
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='amount' value='" + $('#amount').val() + "'/>");
                $form.append("<input type='hidden' name='email' value='" + $('#email').val() + "'/>");
                $form.append("<input type='hidden' name='id' value='" + $('#id').val() + "'/>");
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
</script>

<script type="text/javascript">
  /* enable spacing for credit card number     */
  $('#number').on('keyup', function(e){
    var val = $(this).val();
    var newval = '';
    val = val.replace(/\s/g, '');
    for(var i = 0; i < val.length; i++) {
      if(i%4 == 0 && i > 0) newval = newval.concat(' ');
      newval = newval.concat(val[i]);
    }
    $(this).val(newval);
   });
</script>

</html>
