@extends('layouts.admin')

@section('title')
    Tambah Data
@endsection

@section('container')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                                Tambah Data
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="{{ route('topics.index') }}">
                                <i class="me-1" data-feather="arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Informasi Artikel</div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="name">Judul</label>
                                        <input class="form-control @error('name') is-invalid @enderror" name="title"
                                            type="text" value="{{ old('name') }}" required autofocus />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Image)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="image">Gambar</label>
                                        <input class="form-control @error('image') is-invalid @enderror" name="image"
                                            type="file" value="{{ old('image') }}" required />
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (content)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="content">Content</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="10"
                                            value="{{ old('content') }}"></textarea>
                                        @error('content')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Submit button-->
                                <button class="btn btn-primary" type="submit">
                                    Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
