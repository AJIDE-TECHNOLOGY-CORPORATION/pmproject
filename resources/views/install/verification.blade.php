@extends('install.layout.app')
@section('install_content')

    <div class="wrapper">
        <section class="login-content">
            <div class="container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-sm-12 col-lg-12">
                        <br><br>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">{{ __('all.install_now') }}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ csrf_field() }}
                                @if (Session::has('message'))
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="alert alert-success mb-0" role="alert">
                                            <div class="iq-alert-text">
                                                <h5 class="alert-heading">{{ Session::get('message') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="alert alert-danger mb-0" role="alert">
                                            <div class="iq-alert-text">
                                                <h5 class="alert-heading">{{ implode('', $errors->all(':message')) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <form action="{{ url('install/dbsettings') }}" method="POST">
                                    {{ csrf_field() }}


                                    <div class="form-group {{ $errors->has('license') ? 'has-error' : '' }}">
                                        <label for="pwd">{{ __('all.license') }}<code
                                                class="highlighter-rouge">*</code></label>
                                        <input type="text" value="{{ old('license') }}" name="license"
                                            placeholder="Enter your purchase/license code" id="db-username"
                                            class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">{{ __('all.client') }}<code
                                                class="highlighter-rouge">*</code></label>
                                        <input type="text" value="{{ old('client') }}" name="client_name"
                                            placeholder="Enter your name/envato username" id="client_name"
                                            class="form-control" autocomplete="off">
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ __('all.continue') }}</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
