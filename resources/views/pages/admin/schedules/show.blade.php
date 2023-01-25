@extends('layouts.admin')

@section('title')
    Detail Konsultasi
@endsection

@section('container')
    <main>
        <header class="page-header page-header-dark bg-success pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon">
                                    <i data-feather="file-text"></i>
                                </div>
                                Konsultasi
                            </h1>
                            <div class="page-header-subtitle">Detail Konsultasi</div>
                        </div>
                    </div>
                    <nav class="mt-4 rounded" aria-label="breadcrumb">
                        <ol class="breadcrumb px-3 py-2 rounded mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}">Konsultasi</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4 mt-n10">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Informasi Konsultasi</div>
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">DATA DIRI</button>
                                </li>
                                <li class="nav-item" role="presentation"
                                    @if ($item->type == 1) style="display: none" @endif>
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">CHAT</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <!-- DATA DIRI -->
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <div class="col-lg-3 align-items-center">
                                            <img class="img img-fluid" width="100%" src="{{ $item->patient->profile }}" />
                                        </div>
                                        <div class="col-lg-9">
                                            <table class="table">
                                                <thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Status</th>
                                                        <td>:
                                                            @php
                                                                $status = '-';
                                                                $bg = '';
                                                                if ($item->status == 1) {
                                                                    $status = 'Diajukan';
                                                                    $bg = 'bg-warning';
                                                                }
                                                                
                                                                if ($item->status == 2) {
                                                                    $status = 'Diterima';
                                                                    $bg = 'bg-primary';
                                                                }
                                                                
                                                                if ($item->status == 3) {
                                                                    $status = 'Ditolak';
                                                                    $bg = 'bg-danger';
                                                                }
                                                                
                                                                if ($item->status == 4) {
                                                                    $status = 'Selesai';
                                                                    $bg = 'bg-success';
                                                                }
                                                                
                                                                if ($item->status == 5) {
                                                                    $status = 'Expired';
                                                                    $bg = 'bg-dark';
                                                                }
                                                                
                                                            @endphp
                                                            <span
                                                                class="badge {{ $bg }} text-bold">{{ $status }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Nama</th>
                                                        <td>: {{ $item->patient->full_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">NIM</th>
                                                        <td>: {{ $item->patient->nim }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Fakultas</th>
                                                        <td>:
                                                            {{ isset($item->patient->faculty) ? $item->patient->faculty->title : '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Program Studi</th>
                                                        <td>:
                                                            {{ isset($item->patient->studyProgram) ? $item->patient->studyProgram->title : '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Layanan Konsultasi</th>
                                                        <td>:
                                                            @php
                                                                $type = 'online';
                                                                $typeIcon = 'video';
                                                                
                                                                if ($item->type == 1) {
                                                                    $type = 'offline';
                                                                    $typeIcon = 'smile';
                                                                }
                                                                
                                                            @endphp
                                                            <i class="fa fa-{{ $typeIcon }}" style="color: #00ac69"></i>
                                                            {{ $type }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Topik Konsultasi</th>
                                                        <td>: {{ $item->topic->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Jadwal Konsultasi</th>
                                                        <td>: {{ $item->date . ' ' . $item->time }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 25%">Tanggal diajukan</th>
                                                        <td>: {{ $item->created_at->format('d M Y H.i') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- JIKA STATUS DIAJUKAN --}}
                                    @if ($item->status == 1)
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <h3>Update Konsultasi</h3>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <small>Perubahan status konsultasi akan diinformasikan kepada mahasiswa
                                                        <b>{{ $item->patient->full_name }}</b></small>
                                                </div>
                                                <form action="{{ route('schedules.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Form Row-->
                                                    <div class="row gx-3 mb-3">
                                                        <!-- Form Group (first name)-->
                                                        <div class="col-md-12">
                                                            <select name="status" class="form-select">
                                                                <option value="2">Diterima</option>
                                                                <option value="3">Ditolak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Submit button-->
                                                    <button class="btn btn-success" type="submit" style="float: right">
                                                        Kirim &nbsp; <div class="nav-link-icon"><i data-feather="send"></i>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- JIKA STATUS DITERIMA --}}
                                    @if ($item->status == 2)
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <h3>Hasil Konsultasi (Diagnosis)</h3>
                                                <form action="{{ route('schedules.review', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Form Row-->
                                                    <div class="row gx-3 mb-3">
                                                        <!-- Form Group (first name)-->
                                                        <div class="col-md-12">
                                                            <textarea class="form-control @error('content') is-invalid @enderror" name="diagnosis" rows="15" required></textarea>
                                                            @error('content')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <!-- Submit button-->
                                                    <button class="btn btn-success" type="submit" style="float: right">
                                                        Selesai &nbsp; <div class="nav-link-icon"><i
                                                                data-feather="check-circle"></i>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- JIKA STATUS SELESAI --}}
                                    @if ($item->status == 4)
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <h3>Hasil Konsultasi (Diagnosis)</h3>
                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group (first name)-->
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" name="diagnosis" rows="15" disabled>{{ $item->diagnosis }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- END OF DATA DIRI -->

                                <!-- CHAT -->
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <ul class="list-group list-group-flush p-2 chat-section overflow-auto"
                                                style="max-height: 500px">
                                                @foreach ($chats as $chat)
                                                    <li class="list-group-item"
                                                        style="background: #F7F9FA; @if ($chat->psikolog_id == Auth::user()->id) text-align:right @endif">
                                                        <h6>{{ $chat->psikolog_id != Auth::user()->id ? $chat->patient->full_name : 'You' }}
                                                        </h6>
                                                        <div
                                                            class="row @if ($chat->psikolog_id == Auth::user()->id) text-align:right @endif">
                                                            <small>{{ $chat->messages }}</small>
                                                        </div>
                                                        <i data-feather="clock"
                                                            style="width: 12px; vertical-align: middle"></i><small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($chat->created_at)->addHour(7)->format('H:i') }}</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <textarea class="form-control mb-2 mr-sm-2" rows="5" cols="5" id="chat-msg" placeholder="Type Message..."></textarea>
                                            <button type="submit" class="btn btn-primary mb-2 btn-md" id="chat-send"
                                                style="float: right">Send</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OF CHAT -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        function fetchdata() {
            $.ajax({
                url: "{{ route('chat.ajax', [$item->id]) }}",
                type: 'GET',
                success: function(data) {
                    // Perform operation on return value
                    $('.chat-section').html(data)
                    // $('.chat-section').append(data)
                },
                complete: function(data) {
                    setTimeout(fetchdata, 1000);
                }
            });
        }

        $(document).ready(function() {
            // $('#chat-send').prop('disabled', true);
            setTimeout(fetchdata, 1000);
        });

        $("#chat-send").keypress(function() {
            alert("Handler for .keyup() called.");
            let chat = $('#chat-msg').val();
            if (chat.length > 0) {
                // alert(chat.length)
                $('#chat-send').prop('disabled', false);
            }
        });

        $('#chat-send').on('click', function() {
            $('#chat-send').prop('disabled', true);
            $('#chat-send').text('loading')
            let chat = $('#chat-msg').val();
            $.ajax({
                url: "{{ route('chat.ajax.store', [$item->id]) }}",
                type: 'POST',
                data: {
                    _token: '{!! csrf_token() !!}',
                    msg: chat
                },
                success: function(data) {
                    console.log(data);
                    // Perform operation on return value
                    $('#chat-msg').val('')
                    $('#chat-send').text('Send')
                    $('#chat-send').prop('disabled', false);
                },
            });
        })
    </script>
@endsection
