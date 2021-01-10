<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @yield('dashboard')" aria-current="page" href="/admin/dashboard">
                    <i class="feather icon-home"></i>
                    <span class="nav-item-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @yield('customers')" href="/admin/customers">
                    <i class="feather icon-users"></i>
                    <span class="nav-item-text">Customers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @yield('bookings')" href="/admin/bookings">
                    <i class="feather icon-file"></i>
                    <span class="nav-item-text">Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @yield('services')" href="/admin/services">
                    <i class="feather icon-layers"></i>
                    <span class="nav-item-text">Services</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @yield('admins')" href="/admin/admins">
                    <i class="feather icon-award"></i>
                    <span class="nav-item-text">Admins</span>
                </a>
            </li>
        </ul>
    </div>
</nav>