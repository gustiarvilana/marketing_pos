<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a> --}}

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Superadmin
    </div>

    <!-- Nav Item - Charts -->
    @if (Auth::user()->level == 25 || Auth::user()->level == 99)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>user</span></a>
        </li>
    @endif
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('karyawan.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Karyawan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('karyawan.group') }}">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Tabel Group Marketing</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('kasbon.index') }}">
            <i class="fas fa-fw fa-money-check"></i>
            <span>Kasbon</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('gaji.index') }}">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Data Gaji</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('penjualan_master.index') }}">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Data Penjualan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    @if (Auth::user()->level == 32)
    <!-- Heading -->
    <div class="sidebar-heading">
        Penjualan
    </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Input Penjualan</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('verif.index') }}">
                <i class="fas fa-fw fa-check"></i>
                <span>verifikasi</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('delivery.index') }}">
                <i class="fas fa-fw fa-truck"></i>
                <span>Delivery</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @endif


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>