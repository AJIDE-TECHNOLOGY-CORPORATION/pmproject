@extends('install.layout.app')
@section('install_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.2/css/bulma.min.css"
        crossorigin="anonymous" />
    @if ($status == 'true')
        <div class="wrapper">
            <section class="login-content">
                <div class="container h-100">
                    <div class="row align-items-center justify-content-center h-100">
                        <div class="col-sm-12 col-lg-12">
                            <br><br>
                            <div class="card">

                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">{{ __('all.app_configuration') }}</h4>
                                    </div>
                                </div>

                                <div class="notification is-success is-light"><strong>{{ $message }}</strong></div>
                                <div class="card-body">
                                    <p>{{ __('all.enter_db_details') }}</p>
                                    <form method="POST" action="{{ url('install/postDatabase') }}">
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
                                                        <h5 class="alert-heading">
                                                            {{ implode('', $errors->all(':message')) }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group {{ $errors->has('db.host') ? 'has-error' : '' }}">
                                            <label for="email">{{ __('all.host') }}<code
                                                    class="highlighter-rouge">*</code></label>
                                            <input type="text" class="form-control" value="{{ old('db.host') }}"
                                                name="db[host]" placeholder="Mostly 127.0.0.1 or localhost" id="host"
                                                autofocus>
                                            {!! $errors->first('db.host', ' <span class="help-block">:message</span>') !!}
                                        </div>
                                        <div class="form-group {{ $errors->has('db.port') ? 'has-error' : '' }}">
                                            <label for="pwd">{{ __('all.port') }}<code
                                                    class="highlighter-rouge">*</code></label>
                                            <input type="text" class="form-control" value="{{ old('db.port') }}"
                                                name="db[port]" placeholder="Mostly 3306" id="port">
                                            {!! $errors->first('db.port', ' <span class="help-block">:message</span>') !!}
                                        </div>
                                        <div class="form-group {{ $errors->has('db.database') ? 'has-error' : '' }}">
                                            <label for="pwd">{{ __('all.database') }}<code
                                                    class="highlighter-rouge">*</code></label>
                                            <input type="text" class="form-control" value="{{ old('db.database') }}"
                                                name="db[database]" placeholder="Database name" id="database">
                                        </div>
                                        <div class="form-group {{ $errors->has('db.username') ? 'has-error' : '' }}">
                                            <label for="pwd">{{ __('all.db_username') }}<code
                                                    class="highlighter-rouge">*</code></label>
                                            <input type="text" value="{{ old('db.username') }}" name="db[username]"
                                                placeholder="Database username" id="db-username" class="form-control"
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="pwd">{{ __('all.db_password') }}<code
                                                    class="highlighter-rouge">*</code></label>
                                            <input type="text" value="{{ old('db.password') }}" name="db[password]"
                                                placeholder="Database password" id="db-password" class="form-control"
                                                autocomplete="off">
                                        </div>
                                        <br>
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
    @else
<div class="wrapper">
            <section class="login-content">
                <div class="container h-100">
                    <div class="row align-items-center justify-content-center h-100">
                        <div class="col-sm-12 col-lg-12">
                            <br><br>
                            <div class="card">
                                <div class="notification is-danger is-light"><strong>{{ $message }}</strong></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    @endif
@endsection
