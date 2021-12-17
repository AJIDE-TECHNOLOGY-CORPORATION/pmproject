<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{(isset($site['favicon']) && !empty($site['favicon']) && File::exists('uploads/favicon/'.$site['favicon'])) ? asset('uploads/favicon/'.$site['favicon']):asset('uploads/favicon/favicon.png') }}"/>
    <link rel="stylesheet" href="{{asset('assets/install/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/install/css/backend-plugin.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/install/css/backende209.css?v=1.0.0')}}">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="row no-gutters height-self-center">
                <div class="col-sm-12 text-center align-self-center">
                    <div class="iq-error position-relative">
                        <h2 class="mb-0">{{ __('all.sorry') }}.</h2>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>