<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            {{-- <img src="{{ asset('assets/img/techhouse-logo.png') }}"
                alt="TechHouse Logo"
                class="brand-image opacity-75 shadow"> --}}

            <span class="brand-text fw-semibold">
                TechHouse
            </span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->isAdmin())
                    <!-- Master Data -->
                    <li class="nav-item {{ request()->is('items*') || request()->is('categories*') || request()->is('users*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('items*') || request()->is('categories*') || request()->is('users*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-database-fill"></i>
                            <p>
                                Master Data
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('items.index') }}" class="nav-link {{ request()->is('items*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-box-seam"></i>
                                    <p>Data Barang</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-tags"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>Manajemen User</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Transaksi -->
                    <li class="nav-item {{ request()->is('item-ins*') || request()->is('item-outs*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('item-ins*') || request()->is('item-outs*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-arrow-left-right"></i>
                            <p>
                                Transaksi
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('item-ins.index') }}" class="nav-link {{ request()->is('item-ins*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-box-arrow-in-down"></i>
                                    <p>Barang Masuk</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('item-outs.index') }}" class="nav-link {{ request()->is('item-outs*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-box-arrow-up"></i>
                                    <p>Barang Keluar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Laporan -->
                <li class="nav-item {{ request()->is('report*') && !request()->is('report/stocks') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('report*') && !request()->is('report/stocks') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                        <p>
                            Laporan
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.stocks') }}" class="nav-link {{ request()->is('report/stocks') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Stok</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('report.ins') }}" class="nav-link {{ request()->is('report/ins') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Barang Masuk</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('report.outs') }}" class="nav-link {{ request()->is('report/outs') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Barang Keluar</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pengguna -->
                <li class="nav-header">PENGATURAN</li>

                <li class="nav-item">
                    <a href="{{ route('profiles.index') }}" class="nav-link {{ request()->routeIs('profiles.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Profil</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                            <i class="nav-icon bi bi-box-arrow-right"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>

            </ul>

        </nav>
    </div>
</aside>
