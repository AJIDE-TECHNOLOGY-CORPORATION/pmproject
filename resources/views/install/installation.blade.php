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
                                    <h4 class="card-title">{{__('all.install_now')}}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="tbl-col-1">{{__('all.extensions')}}</th>
                                        <th class="tbl-col-2">{{__('all.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($requirement->extensions() as $label => $satisfied)
                                        <tr>
                                            <td>
                                                {{$label}}
                                                @if($label == "PHP = 7.2.x" && !$satisfied)
                                                    <br>
                                                    <span class="text-danger"><b>{{__('all.php_version_msg')}}</b></span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <i class="fa fa-{{$satisfied ? 'check' : 'times'}}"
                                                   aria-hidden="true"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <p><code class="highlighter-rouge">{{__('all.alert_install')}}</code></p>
                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="tbl-col-1">{{__('all.directories')}}</th>
                                        <th class="tbl-col-2">{{__('all.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($requirement->directories() as $label => $satisfied)
                                        <tr>
                                            <td>{{$label}}</td>
                                            <td class="text-center">
                                                <i class="fa fa-{{$satisfied ? 'check' : 'times'}}"
                                                   aria-hidden="true"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <a href="{{$requirement->satisfied() ? url('install/verification') : '#'}}"
                                   class="btn btn-primary btn-block" {{$requirement->satisfied() ? '' : 'disabled'}}>{{__('all.continue')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection