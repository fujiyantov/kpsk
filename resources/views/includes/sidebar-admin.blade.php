<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading ">Akun</div>
            <!-- Profile -->
            <a class="nav-link" href="{{ route('setting.index') }}">
                <div class="row">
                    <div class="col-xxl-6 col-xl-12">
                        <img class="img rounded-circle" width="75"
                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="" />
                    </div>
                    <div class="col-xxl-6 col-xl-12 d-flex">
                        <p class="align-self-center d-none d-lg-block">Hello, <br /> {{ ucwords(Auth::user()->name) }}
                        </p>
                    </div>
                </div>
                {{-- @endif --}}
            </a>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Sidenav Link (Dashboard)-->
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                href="{{ route('admin-dashboard') }}">
                <div class="nav-link-icon"><i data-feather="home"></i></div>
                Beranda
            </a>

            @if (Auth::user()->role_id == 3)
                <a class="nav-link {{ request()->is('admin/schedules*') ? 'active' : '' }}"
                    href="{{ route('schedules.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Daftar Konsultasi
                </a>
            @endif

            @if (Auth::user()->role_id == 2)
                <a class="nav-link {{ request()->is('admin/schedules*') ? 'active' : '' }}"
                    href="{{ route('schedules.rekap') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Daftar Rekapitulasi
                </a>
            @endif

            @if (Auth::user()->role_id == 1)
                <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Daftar Pengguna
                </a>


                <a class="nav-link {{ request()->is('admin/news*') ? 'active' : '' }}"
                    href="{{ route('news.index') }}">
                    <div class="nav-link-icon"><i data-feather="folder"></i></div>
                    Artikel
                </a>
                <a class="nav-link {{ request()->is('admin/topics*') ? 'active' : '' }}"
                    href="{{ route('topics.index') }}">
                    <div class="nav-link-icon"><i data-feather="folder"></i></div>
                    Topik
                </a>
            @endif
            <a class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}"
                href="{{ route('setting.index') }}">
                <div class="nav-link-icon"><i data-feather="lock"></i></div>
                Akun
            </a>
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">{{ ucwords(Auth::user()->name) }}</div>
        </div>
    </div>
</nav>
