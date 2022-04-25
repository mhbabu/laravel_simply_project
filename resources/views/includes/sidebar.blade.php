<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light ml-5">{{ env('APP_NAME','Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index') }}" class="nav-link {{ (request()->is('admin/dashboard*') ? 'active' : '') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li class="nav-item has-treeview {{ (request()->is('admin/product*') ? 'menu-open' : '') }}">
                    <a href="#" class="nav-link {{ (request()->is('admin/product*') ? 'active' : '') }}">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>Product Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ (request()->is('admin/products*') ? 'active' : '') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.product.categories.index') }}" class="nav-link {{ (request()->is('admin/product/categories*') ? 'active' : '') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.product.subcategories.index') }}" class="nav-link {{ (request()->is('admin/product/subcategories*') ? 'active' : '') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Subcategories</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
