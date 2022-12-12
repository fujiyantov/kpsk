@extends('layouts.admin')

@section('title')
    Edit Data
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
                                Edit Data
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
                        <div class="card-header">Informasi Topik</div>
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
                            <form action="{{ route('topics.update', [$resource->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @csrf
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="name">Nama</label>
                                        <input class="form-control @error('name') is-invalid @enderror" name="title"
                                            type="text" value="{{ $resource->title }}" required autofocus />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Category)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="category_id">Kategori</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                            name="category_id">
                                            <option value="1" @if ($resource->category_id == 1) selected @endif>
                                                Category 1</option>
                                            <option value="2" @if ($resource->category_id == 2) selected @endif>
                                                Category 2</option>
                                            <option value="3" @if ($resource->category_id == 3) selected @endif>
                                                Category 3</option>
                                            <option value="4" @if ($resource->category_id == 4) selected @endif>
                                                Category 4</option>
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (description)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="description">Keterangan</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="10">{{ $resource->description }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <div class="col-md-12">
                                        @if (substr($resource->image, 0, 5) == 'https')
                                            <img src="{{ $resource->image }}" class="img-thumbnail" width="250"
                                                alt="image_village">
                                        @else
                                            <img src="{{ Storage::url('/assets/images/' . $resource->image) }}"
                                                class="img-thumbnail" width="250" alt="image_village">
                                        @endif
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Image)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="image">Banner</label>
                                        <input class="form-control @error('image') is-invalid @enderror" name="image"
                                            type="file" value="{{ old('image') }}"/>
                                        @error('image')
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
