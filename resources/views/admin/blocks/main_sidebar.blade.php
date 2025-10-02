<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
        <img src="{{ asset('admin_asset/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('user_asset/images/user1.svg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Sơn Trần</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @php
                    $managementMenuOpen =
                        Request::routeIs('admin.user.*') ||
                        Request::routeIs('admin.product_category.*') ||
                        Request::routeIs('admin.product.*') ||
                        Request::routeIs('admin.order.*') ||
                        Request::routeIs('admin.feedback*');
                @endphp
                <li class="nav-item has-treeview {{ $managementMenuOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Quản lý
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.list') }}"
                                class="nav-link {{ Request::routeIs('admin.user.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Người dùng</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.product_category.list') }}"
                                class="nav-link {{ Request::routeIs('admin.product_category.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh mục sản phẩm</p>
                            </a>

                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.product.list') }}"
                                class="nav-link {{ Request::routeIs('admin.product.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sản phẩm</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.order.list') }}"
                                class="nav-link {{ Request::routeIs('admin.order.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đơn hàng</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.feedback') }}"
                                class="nav-link {{ Request::routeIs('admin.feedback*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Phản hồi</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <!-- Doanh thu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @php
                    $managementMenuOpen =
                        Request::routeIs('admin.report.saleSummary') ||
                        Request::routeIs('admin.product_category.*') ||
                        Request::routeIs('admin.product.*') ||
                        Request::routeIs('admin.order.*') ||
                        Request::routeIs('admin.feedback*');
                @endphp
                <li class="nav-item has-treeview {{ $managementMenuOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Doanh thu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.report.saleSummary') }}"
                                class="nav-link {{ Request::routeIs('admin.report.saleSummary') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tổng doanh thu</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.Doanh thu -->
    </div>
    <!-- /.sidebar -->
</aside>
