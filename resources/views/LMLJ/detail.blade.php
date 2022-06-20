@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lembar Masalah</h4>
                            <div class="card-header-action">
                                Tanggal Dikirim
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-10 col-md-10 col-lg-10">
                                    <button type="button" class="btn btn-dark">
                                        <h4 class="mt-2">UNIT-LMLJ/06/22/0001</h4>
                                    </button>
                                </div>
                                <div class="col-2 col-md-2 col-lg-2">
                                    <figure class="avatar mr-2 avatar-lg bg-danger text-white" data-initial="3"></figure>
                                    {{-- <button type="button" class="btn btn-danger">
                                        <h4 class="mt-2">3</h4>
                                    </button> --}}
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col mb-0">
                                    Nama produk <b>Lorem ipsum</b>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    Nomor produk <b>Lorem ipsum</b>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    Nama Komponen <b>Lorem ipsum</b>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    Nomor Komponen <b>Lorem ipsum</b>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    Foto/Video
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    <div class="gallery gallery-md">
                                        <div class="gallery-item" data-image="assets/img/news/img03.jpg"
                                            data-title="Image 1"></div>
                                        <div class="gallery-item" data-image="assets/img/news/img14.jpg"
                                            data-title="Image 2"></div>
                                        <div class="gallery-item" data-image="assets/img/news/img08.jpg"
                                            data-title="Image 3"></div>
                                        <div class="gallery-item" data-image="assets/img/news/img05.jpg"
                                            data-title="Image 4"></div>
                                        <div class="gallery-item gallery-more" data-image="assets/img/news/img08.jpg"
                                            data-title="Image 12">
                                            <div>+2</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    Detail Masalah
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="text-dark">1. Lorem ipsum dolor sit, amet consectetur adipisicing elit. A
                                        minus est dolorem cupiditate consectetur excepturi nemo magnam quae corrupti ullam?
                                    </p>
                                    <p class="text-dark">2. Lorem ipsum dolor sit, amet consectetur adipisicing elit. A
                                        minus est dolorem cupiditate consectetur excepturi nemo magnam quae corrupti ullam?
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    Nilai Tambah
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="text-dark">1. Lorem ipsum dolor sit, amet consectetur adipisicing elit. A
                                        minus est dolorem cupiditate consectetur excepturi nemo magnam quae corrupti ullam?
                                    </p>
                                    <p class="text-dark">2. Lorem ipsum dolor sit, amet consectetur adipisicing elit. A
                                        minus est dolorem cupiditate consectetur excepturi nemo magnam quae corrupti ullam?
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col text-center">
                                    <div class="row mb-2">
                                        <div class="col">Diketahui</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <figure class="avatar mr-2 avatar-lg" data-initial="NH"></figure>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Yang Mengetahui</div>
                                    </div>
                                </div>
                                <div class="col text-center">
                                    <div class="row mb-2">
                                        <div class="col">Pengaju</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <figure class="avatar mr-2 avatar-lg" data-initial="AN"></figure>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Nama Pengaju</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <h2 class="section-title">Status LMLJ</h2>
                    <div class="row">
                        <div class="col">Unit Pengadu</div>
                        <div class="col">Unit Tujuan</div>
                        <div class="col">3</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="progress mb-3" data-height="5">
                                <div class="progress-bar" role="progressbar" data-width="40%" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">Tanggal Dikirim</div>
                        <div class="col">Tanggal Diterima</div>
                        <div class="col">3</div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Lembar Jawaban</h4>
                                    <div class="card-header-action">
                                        Tanggal Diterima
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <h4 class="mt-2 text-dark">Unit Tujuan</h4>
                                        </div>
                                        <div class="col-4 text-center">
                                            <figure class="avatar mt-1 avatar-md bg-warning text-white" data-initial="7">
                                            </figure><br>
                                            <div class="badge badge-info mt-3">Diteruskan</div><br>

                                        </div>
                                        <div class="col-4 text-right">
                                            <div class="row mb-2">
                                                <div class="col">Penerima</div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <figure class="avatar mr-2 avatar-sm" data-initial="AN"></figure>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">Nama Penerima</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="detailjawaban">
                                        <div class="row mt-2">
                                            <div class="col">
                                                Analisa Masalah
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-dark">1. Lorem ipsum dolor sit, amet consectetur adipisicing
                                                    elit. A
                                                    minus est dolorem cupiditate consectetur excepturi nemo magnam quae
                                                    corrupti ullam?
                                                </p>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Perbaikan 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-dark">1. Lorem ipsum dolor sit, amet consectetur adipisicing
                                                    elit. A
                                                    minus est dolorem cupiditate consectetur excepturi nemo magnam quae
                                                    corrupti ullam?
                                                </p>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Nilai Tambah 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-dark">1. Lorem ipsum dolor sit, amet consectetur adipisicing
                                                    elit. A
                                                    minus est dolorem cupiditate consectetur excepturi nemo magnam quae
                                                    corrupti ullam?
                                                </p>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Keputusan 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-dark">1. Lorem ipsum dolor sit, amet consectetur adipisicing
                                                    elit. A
                                                    minus est dolorem cupiditate consectetur excepturi nemo magnam quae
                                                    corrupti ullam?
                                                </p>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Lampiran 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="gallery gallery-md">
                                                    <div class="gallery-item" data-image="assets/img/news/img03.jpg"
                                                        data-title="Image 1"></div>
                                                    <div class="gallery-item" data-image="assets/img/news/img14.jpg"
                                                        data-title="Image 2"></div>
                                                    <div class="gallery-item" data-image="assets/img/news/img08.jpg"
                                                        data-title="Image 3"></div>
                                                    <div class="gallery-item" data-image="assets/img/news/img05.jpg"
                                                        data-title="Image 4"></div>
                                                    <div class="gallery-item gallery-more" data-image="assets/img/news/img08.jpg"
                                                        data-title="Image 12">
                                                        <div>+2</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a data-toggle="collapse" href="#detailjawaban" class="btn btn-icon btn-primary"><i
                                            class="fas fa-angle-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
