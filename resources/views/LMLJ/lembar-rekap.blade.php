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
                    <div class="breadcrumb-item"><a href="/rekap-progress-lmlj">Rekap Progress LMLJ</a></div>
                    <div class="breadcrumb-item">Lembar Rekap</div>
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
                {{-- Lembar Rekap LMLJ --}}
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lembar Rekap</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="input-perbaikan">Perbaikan Masalah</label>
                                    <textarea style="height: 70px;" class="form-control" id="input-perbaikan"
                                        placeholder="Masukkan detail masalah"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="input-nilai-tambah">Nilai Tambah</label>
                                    <input type="text" class="form-control" id="input-nilai-tambah"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="input-keputusan">Keputusan</label>
                                    <textarea style="height: 70px;" class="form-control" id="input-keputusan"
                                        placeholder="Masukkan detail masalah"></textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="input-lampiran">Lampiran</label>
                                        <input type="file" class="form-control" id="input-lampiran">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="input-status">Status</label>
                                        <input type="text" class="form-control" id="input-status">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama-pembuat">Nama Pembuat Rekap</label>
                                    <input type="text" class="form-control" id="input-nama-pembuat"
                                        placeholder="">
                                </div>
                                <div class="form-group float-right">
                                    <button type="submit" class="btn btn-primary">Rekap</button>
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
