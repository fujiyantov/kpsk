@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('container')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </h1>
                            <div class="page-header-subtitle">Administrator Panel</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <!-- Example Colored Cards for Dashboard Demo-->
            <!-- 2 = admin, 3 -->
            {{-- @if (Auth::user()->role_id == 1 || Auth::user()->role_id >= 9) --}}
            <div class="row">
                {{-- @if (Auth::user()->role_id == 1) --}}
                {{-- <div class="col-lg-12 col-xl-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="-75 small">Total User</div>
                                            <div class="text-lg fw-bold">{{ $masuk }}</div>
                                        </div>
                                        <i class="feather-xl -50" data-feather="users"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class=" stretched-link" href="{{ route('surat-masuk') }}">Selengkapnya</a>
                                    <div class=""><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div> --}}
                {{-- @endif --}}
                @php
                    $roleID = [1, 8, 9, 10, 11, 12, 13];
                @endphp
                @if (in_array(Auth::user()->role_id, $roleID))
                    <div class="col-lg-12 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="-75 small">Total</div>
                                        <div class="text-lg fw-bold">{{ $masuk }}</div>
                                    </div>
                                    <i class="feather-xl -50" data-feather="download"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class=" stretched-link" href="#">Selengkapnya</a>
                                <div class=""><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="col-lg-12 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="-75 small">Total Proposal Keluar</div>
                                        <div class="text-lg fw-bold">{{ $keluar }}</div>
                                    </div>
                                    <i class="feather-xl -50" data-feather="upload"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class=" stretched-link" href="{{ route('proposal-keluar.index') }}">Selengkapnya</a>
                                <div class=""><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div> --}}
            </div>
            {{-- @endif --}}
            <div class="row">
                <div class="col-xxl-12 col-xl-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body h-100 p-5">
                            <div class="row align-items-center">
                                <div class="col-xl-8 col-xxl-12">
                                    <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                        <h1 class="text-primary">Selamat Datang {{ Auth::user()->name }}!</h1>
                                        <p class="text-gray-700 mb-0">Di Website Aplikasi</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid"
                                        src="/admin/assets/img/illustrations/at-work.svg" style="max-width: 26rem" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
