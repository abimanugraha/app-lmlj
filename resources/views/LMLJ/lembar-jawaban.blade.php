@extends('layout/main')

@section('content')
    <style>
        figcaption {
            rotate: -9deg;
            margin-top: -10%;
            color: rgb(243, 44, 44);
        }
    </style>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="/kotak-masuk-lmlj">Kotak Masuk LMLJ</a></div>
                    <div class="breadcrumb-item">Lembar Jawaban</div>
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
                                    {{-- <figure>
                                        <img src="assets/img/solved.png" alt="status" style="width:80%">
                                        <figcaption>Tanggal Selesai</figcaption>
                                    </figure> --}}

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
                {{-- Lembar Jawaban LMLJ --}}
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lembar Jawaban</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="input-analisa-masalah">Analisa Masalah</label>
                                    <textarea style="height: 70px;" class="form-control" id="input-analisa-masalah" rows="3"
                                        placeholder="Masukkan detail masalah"></textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="input-urgensi">Urgensi</label>
                                        <input type="text" class="form-control" id="input-urgensi">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="input-target">Target Penyelesaian</label>
                                        <input type="text" class="form-control" id="input-target">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <div class="mt-4"></div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check-teruskan">
                                            <label class="form-check-label" for="check-teruskan">
                                                Teruskan?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="input-unit-tujuan">Unit Tujuan</label>
                                        <input type="text" class="form-control" id="input-unit-tujuan" disabled>
                                    </div>
                                </div>
                                <div class="form-group float-right">
                                    <button type="submit" class="btn btn-primary">Jawab</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById("check-teruskan").onclick = function() {
            show()
        };

        function show() {
            var x=$("#check-teruskan").is(":checked");
            if(x){
                document.getElementById('input-unit-tujuan').disabled = false;
            }else{
                document.getElementById('input-unit-tujuan').disabled = true;
            }
        }
    </script>
@endsection
