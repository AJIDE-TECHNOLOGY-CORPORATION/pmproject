<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Invoice Estimate Management System" name="description">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @php
        $settings = new App\MasterSetting();
        $site = $settings->siteData();
        $currency = ($site['default_currency'] && $site['default_currency']) !=""? $site['default_currency'] : '₹';
    @endphp
    <title>{{(isset($site['site_title']) && !empty($site['site_title']) ) ? $site['site_title'] : "Invoxi"}} | @yield('title') </title>
    <link rel="icon" href="{{(isset($site['favicon']) && !empty($site['favicon']) && File::exists('uploads/favicon/'.$site['favicon'])) ? asset('uploads/favicon/'.$site['favicon']):asset('uploads/favicon/favicon.png')}}" type="image/x-icon"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/bs-stepper/css/bs-stepper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/dropzone/min/dropzone.min.css')}}">
    <script src="{{asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/common/my_js.js')}}"></script>
    <script src="{{asset('assets/common/validation.js')}}"></script>
    <script src="{{asset('assets/common/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/backend/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/dropify.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/custom.css')}}">
    @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
@include('layouts.customer-sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
    <footer class="main-footer hidden_div">
        <strong>Copyright &copy; 2021 {{(isset($site['company_name']) && !empty($site['company_name']) ) ? $site['company_name'] : "Invoxi"}}</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version:</b>  <strong class="text-primary">{{ version_display() }}</strong>
        </div>
    </footer>
</div>
<script src="{{asset('assets/common/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/backend/dist/js/adminlte.js')}}"></script>
<script src="{{asset('assets/backend/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{asset('assets/common/dropify.min.js')}}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
<script src="{{asset('assets/common/ckeditor/ckeditor.js')}}"></script>
@stack('js')
<script>
    "use strict";
    @if(Session::has('message'))
    /* if session has success message */
    swal("Success!", "{{session('message')}}", "success")
    @endif
    @if(Session::has('error'))
    /* if session has error message */
    swal("Failure!", "{{session('error')}}", "error")
    @endif
</script>
<script>
    'use strict';
    $('.dropify').dropify();
</script>
</body>
</html>
