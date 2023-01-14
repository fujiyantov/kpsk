<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
    id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle">
        <i data-feather="menu"></i>
    </button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('admin-dashboard') }}">
        Konsultasi Psikolog IMM
    </a>
    <!-- Navbar Search Input-->
    <!-- * * Note: * * Visible only on and above the lg breakpoint-->
    <form class="form-inline me-auto d-none d-lg-block me-3">
        <div class="input-group input-group-joined input-group-solid">

        </div>
    </form>
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <!-- Navbar Search Dropdown-->
        <!-- * * Note: * * Visible only below the lg breakpoint-->

        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">

            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span class="badge text-danger ms-auto btn-notif"><span class="notif-value">9</span><i
                        data-feather="bell" style="color: #00ac69"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                aria-labelledby="navbarDropdownUserImage">
                <ul class="list-group list-group-flush p-2" style="width: 25rem;">
                    <div class="overflow-auto" style="max-height: 500px">
                        <li class="list-group-item" style="background: #F7F9FA">
                            <a href="">
                                <h6>Hallo <i data-feather="arrow-right"></i>
                                    Hei</h6>
                            </a>
                            <small><i data-feather="calendar"></i>
                                {{ date('Y-m-d H:i') }}</small> <br />
                            <small class="text-muted">Lorem ipsum dolor sit amet consectetur</small>
                        </li>
                </ul>
            </div>
            </div>
        </li>

        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                {{-- @if (Auth::user()->profile != null)
                    <img class="img-fluid" src="{{ Storage::url(Auth::user()->profile) }}" />
                @else --}}
                <img class="img-fluid" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" />
                {{-- @endif --}}
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    {{-- @if (Auth::user()->profile != null)
                        <img class="dropdown-user-img" src="{{ Storage::url(Auth::user()->profile) }}" />
                    @else --}}
                    <img class="dropdown-user-img" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" />
                    {{-- @endif --}}

                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ ucwords(Auth::user()->name) }}</div>
                        <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('setting.index') }}">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Account
                </a>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
