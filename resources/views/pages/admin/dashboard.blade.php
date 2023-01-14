@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('container')
    <main>
        <header class="page-header page-header-dark bg-success pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Beranda
                            </h1>
                            <div class="page-header-subtitle">Rekapitulasi Panel</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <div class="row">
                <div class="col-lg-12 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="-75 small">Total Topik</div>
                                    <div class="text-lg fw-bold">{{ $topic }}</div>
                                </div>
                                <i class="feather-xl -50" data-feather="folder"></i>
                            </div>
                        </div>

                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            @if (Auth::user()->role_id == 1)
                                <a class=" stretched-link" href="{{ route('topics.index') }}">Selengkapnya</a>
                                <div class=""><i class="fas fa-angle-right"></i></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="-75 small">Total Mahasiswa</div>
                                    <div class="text-lg fw-bold">{{ $mahasiswa }}</div>
                                </div>
                                <i class="feather-xl -50" data-feather="users"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            @if (Auth::user()->role_id == 1)
                                <a class=" stretched-link" href="{{ route('user.index') }}">Selengkapnya</a>
                                <div class=""><i class="fas fa-angle-right"></i></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="-75 small">Total Artikel</div>
                                    <div class="text-lg fw-bold">{{ $topic }}</div>
                                </div>
                                <i class="feather-xl -50" data-feather="folder"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            @if (Auth::user()->role_id == 1)
                                <a class=" stretched-link" href="{{ route('news.index') }}">Selengkapnya</a>
                                <div class=""><i class="fas fa-angle-right"></i></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
            <div class="row">
                <div class="col-xxl-12 col-xl-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body h-100 p-5">
                            <div class="row align-items-center">
                                <div class="col-xl-12 col-xxl-12">
                                    <div>
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @php echo '["' . implode('", "', $topicName) . '"]' @endphp,
                datasets: [{
                    label: 'Rekapitulasi Konsultasi Mahasiswa',
                    data: @php echo '["' . implode('", "', $topicData) . '"]' @endphp,
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
