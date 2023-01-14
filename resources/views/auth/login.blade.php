@extends('layouts.auth')

@section('main')
    <main>
        <div class="container-xl px-4 d-flex justify-content-center align-items-center mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Basic login form-->
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session()->has('loginError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('loginError') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <!-- Login form-->
                            <div class="row">
                                <div class="col-md-5">
                                    <img src="{{ asset('logo.png') }}" alt="" class="img img-fluid">
                                </div>
                                <div class="col-md-7">
                                    <form action="/login" method="post">
                                        @csrf
                                        <div class="mb-3 mt-5">
                                            <h3>Konsultasi Psikolog IMM</h3>
                                        </div>
                                        <!-- Form Group (email address)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email">Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" type="email" value="{{ old('email') }}"
                                                placeholder="Enter email address" autofocus required />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control" id="password" name="password" type="password"
                                                placeholder="Enter password" required />
                                        </div>
                                        <!-- Form Group (remember password checkbox)-->

                                        <!-- Form Group (login box)-->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">

                                            </a>
                                            <button type="submit" class="btn btn-success">Login &nbsp;<i class="fa fa-arrow-right"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">
                                All rights reserved &copy;{{ date('Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
