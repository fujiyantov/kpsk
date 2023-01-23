@extends('layouts.admin')

@section('title')
    Pengguna - Set Jadwal Konsultasi
@endsection

@section('container')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Pengguna - Set Jadwal Konsultasi
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
                <a class="nav-link {{ request()->is('admin/setting') ? 'active ms-0' : '' }}"
                    href="{{ route('setting.index') }}">Profil</a>
                <a class="nav-link {{ request()->is('admin/setting/password') ? 'active ms-0' : '' }}"
                    href="{{ route('change-password') }}">Ubah Password</a>
                @if (Auth::user()->role_id == 3)
                    <a class="nav-link {{ request()->is('admin/setting/schedules') ? 'active ms-0' : '' }}"
                        href="{{ route('schedules-set') }}">Ubah Jadwal Konsultasi</a>
                @endif
            </nav>
            <hr class="mt-0 mb-4" />
            <div class="row">
                <div class="col-lg-8">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Change password card-->
                    <div class="card mb-4">
                        <div class="card-header">Ubah Password</div>
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('update.schedule') }}" method="POST">
                                @csrf
                                <!-- Form Group (current password)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="current_password">Pilih Hari</label>
                                    <select name="day" class="form-select" required>
                                        <option value="1">Senin</option>
                                        <option value="2">Selasa</option>
                                        <option value="3">Rabu</option>
                                        <option value="4">Kamis</option>
                                        <option value="5">Jumat</option>
                                        <option value="6">Sabtu</option>
                                        <option value="0">Minggu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="current_password">Pilih Hari Lainnya</label>
                                    <select name="day_2" class="form-select" required>
                                        <option value="1">Senin</option>
                                        <option value="2">Selasa</option>
                                        <option value="3">Rabu</option>
                                        <option value="4">Kamis</option>
                                        <option value="5">Jumat</option>
                                        <option value="6">Sabtu</option>
                                        <option value="0">Minggu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="form-outline timepicker">
                                        <label class="small mb-1" for="current_password">Pilih Jam</label>
                                        <input type="time" name="time" class="form-control" id="form1"
                                            value="12:00">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-outline">
                                        <label class="small mb-1" for="current_password">Tempat Konsultasi</label>
                                        <input type="text" name="meet_at" class="form-control" id="form1">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-outline">
                                        <label class="small mb-1" for="current_password">No Telp (whatsapp)</label>
                                        <input type="number" name="no_telp" class="form-control">
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Perbarui Jadwal &nbsp; <div
                                        class="nav-link-icon"><i data-feather="check-circle"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
