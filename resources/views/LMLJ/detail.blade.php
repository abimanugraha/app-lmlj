@extends('layout/main')

@section('content')
    <style>
        figcaption {
            rotate: -9deg;
            margin-top: -10%;
            color: rgb(243, 44, 44);
        }


        .progressbar {            
            counter-reset: step;
            margin-inline-start: -7%;
            margin-bottom: 0;
        }

        .progressbar li {
            /* list-style: none; */
            display: inline-block;
            width: {{ $lebar_status }};
            position: relative;
            text-align: center;
            /* cursor: pointer; */
        }

        .progressbar li:before {
            content: '';
            /* padding: 5%; */
            counter-increment: step;
            width: 25px;
            height: 25px;
            line-height: 25px;
            /* border: 1px solid #47c363; */
            border-radius: 100%;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            background-color: #cdd3d8;
        }

        .progressbar li:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: #ddd;
            top: 12.5px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {
            color: #47c363;

        }

        .progressbar li.active:before {
            border: 2px solid #47c363;
        }

        .progressbar li.active+li:after {
            background-color: #47c363;
        }
    </style>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="row mb-1">
                                        <div class="col mb-0">
                                            Nama produk <b class="text-dark">Lorem ipsum</b>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col">
                                            Nomor produk <b class="text-dark">Lorem ipsum</b>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col">
                                            Nama Komponen <b class="text-dark">Lorem ipsum</b>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col">
                                            Nomor Komponen <b class="text-dark">Lorem ipsum</b>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col">
                                            Foto/Video
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 text-right">
                                    <figure>
                                        <img src="assets/img/solved.png" alt="status" style="width:80%">
                                        <figcaption>Tanggal Selesai</figcaption>
                                    </figure>

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
                {{-- Status Progress LMLJ --}}
                <div class="col-12 col-md-6 col-lg-6">
                    <h2 class="section-title">Status LMLJ</h2>
                    <div class="row">
                        <div class="col text-center">
                            <ul class="progressbar">
                                <li class="active">CR</li>
                                <li class="active">BT</li>
                                <li class="active">HE</li>
                                <li class="active">Selesai</li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="row">
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
                    </div> --}}
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
                                        <div class="row mt-2">
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
                                                    <div class="gallery-item gallery-more"
                                                        data-image="assets/img/news/img08.jpg" data-title="Image 12">
                                                        <div>+2</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a data-toggle="collapse" href="#detailjawaban" id="btn-detail-jawaban"
                                        class="btn btn-icon btn-secondary">
                                        <i class="fas fa-angle-down"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById("btn-detail-jawaban").onclick = function() {
            show()
        };

        function show() {
            $('#btn-detail-jawaban').find("i").toggleClass("fa-angle-down fa-angle-up");
        }
    </script>
@endsection
