<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{__('all.customer_login')}}</title>
    @php
        $settings = new App\MasterSetting();
        $site = $settings->siteData();
    @endphp
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/custom.css')}}">
</head>
<body class="hold-transition login-page login-pagebg">
<div class="login-box">
    <div class="card card-outline new-card">
        <div class="card-header text-center">
        
        <span class="h1"><b>{{__('all.customer_login')}}</b></span>
    </div>
    <div class="card-body">
        <p class="login-box-msg">{{__('all.login_msg')}}</p>
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>{{session('error')}} </strong>
            </div>
        @endif
        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="errorTxt"></div>
        <form method="post" action="{{url('/customer')}}"  id="MyFormMaster">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="{{__('all.email')}}" name="email" id="email"/>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control"  placeholder="{{__('all.password')}}" name="password" id="password" autocomplete="on"/>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-block btn-grad">{{__('all.login')}}</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
<script src="{{asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/common/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/backend/dist/js/adminlte.min.js')}}"></script>
<script>
    /* login form validation */
    (function($) {
        "use strict";
        $("#MyFormMaster").validate({
            errorClass: 'text-danger',
            rules: {
                'email': {
                    required: true,
                    email: true,
                },
                'password': {
                    required: true,
                    minlength: 6,
                },
            },
            messages: {
                'email': {
                    required: "Email Required.",
                },
                'password': {
                    required: "Password Required.",
                },
            },
            errorElement: 'div',
            errorLabelContainer: '.errorTxt'
        });
    })(jQuery);
</script>
</body>
</html>