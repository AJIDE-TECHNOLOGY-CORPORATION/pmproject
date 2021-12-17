<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="brand-link">
        <img src="{{(isset($site['favicon']) && !empty($site['favicon']) && File::exists('uploads/favicon/'.$site['favicon'])) ? asset('uploads/favicon/'.$site['favicon']):asset('uploads/favicon/favicon.png')}}" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{(isset($site['site_title']) && !empty($site['site_title']) ) ? $site['site_title'] : "Invoxi"}}</span>
        </div>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{(isset(Auth::user()->avatar) && !empty(Auth::user()->avatar) && File::exists('uploads/profile/'.Auth::user()->avatar)) ? asset('uploads/profile/'.Auth::user()->avatar):asset('uploads/profile/default.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{(Session::has('name')) ? Session::get('name') : ""}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('customer/dashboard')}}" class="nav-link  {{ Request::is('customer/dashboard') ? 'active text-dark ' : null }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{__('all.dashboard')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">

                    @php
                        $customer_id = (Session::has('id')) ? Session::get('id') : "";
                        $customer_id = base64_encode($customer_id);
                    @endphp

                    <a href="{{url('customer/edit-profile/'.$customer_id)}}" class="nav-link  {{ Request::is('customer/edit-profile*') ? 'active text-dark ' : null }}">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>
                            {{__('all.profile')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('customer/estimates')}}" class="nav-link  {{ Request::is('customer/estimates*') ? 'active text-dark ' : null }}">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            {{__('all.estimates')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('customer/invoices')}}" class="nav-link  {{ Request::is('customer/invoices*') ? 'active text-dark ' : null }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            {{__('all.invoices')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('customer/payments')}}" class="nav-link  {{ Request::is('customer/payments*') ? 'active text-dark ' : null }}">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>
                            {{__('all.payments')}}
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('customer/orders')}}" class="nav-link  {{ Request::is('customer/orders*') ? 'active text-dark ' : null }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            {{__('all.orders')}}
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('customer-logout')}}" class="nav-link ">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            {{__('all.signout')}}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
