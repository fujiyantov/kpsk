@extends('layouts.admin')

@section('title')
    Proposal
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
                                Proposal
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-header-actions mb-4">
                        <div class="card-header">
                            Lihat Proposal
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12 text-center">
                                <iframe
                                    src="https://drive.google.com/viewerng/viewer?embedded=true&url=http://infolab.stanford.edu/pub/papers/google.pdf#toolbar=0&scrollbar=0"
                                    frameBorder="0" scrolling="auto" height="600px" width="70%"></iframe>

                                <div class="col-lg-4 offset-4">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i
                                                data-feather="edit"></i> &nbsp; Edit Proposal</button>
                                        <button class="btn btn-primary" type="submit"><i data-feather="upload"></i> &nbsp;
                                            Disposisi</button>
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
