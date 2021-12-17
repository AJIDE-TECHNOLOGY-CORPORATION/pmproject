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
                                <div class="alert alert-success mb-0" role="alert">
                                    <div class="iq-alert-text">
                                        <h5 class="alert-heading">{{__('all.well_done')}}</h5>
                                        <p>{{__('all.install_success_msg')}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="email">{{__('all.email')}}<code class="highlighter-rouge">*</code></label>
                                        <b>demo@demo.com</b>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">{{__('all.password')}}<code class="highlighter-rouge">*</code></label>
                                        <b> 123456</b>
                                    </div>
                                    <br>
                                    <a href="{{route('admin-login')}}" class="btn btn-primary btn-block">{{__('all.go_to_login')}}</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection