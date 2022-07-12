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
                    <div class="breadcrumb-item"><a href="{{ url('rekap-progress-lmlj') }}">Rekap Progress LMLJ</a></div>
                    <div class="breadcrumb-item">Lembar Rekap</div>
                </div>
            </div>
            <div class="row">
                @include('section.masalah')
                {{-- Lembar Rekap LMLJ --}}
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lembar Rekap</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('lembar-rekap-progress') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4" id="tanggal">
                                        <label for="input-tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id="input-tanggal" name="tanggal[]"
                                            required>
                                    </div>
                                    <div class="form-group d-flex flex-column col-md-8" id="perbaikan">
                                        <label for="input-perbaikan">Perbaikan</label>
                                        <div class="d-inline-flex mb-2">
                                            <input autofocus="" required name="perbaikan[]" type="text"
                                                class="form-control @error('perbaikan.*') is-invalid @enderror"
                                                id="input-perbaikan" placeholder="Perbaikan ">
                                            <a class="btn btn-icon btn-primary ml-1 text-white" id="btn-tambah-perbaikan"
                                                onclick="tambahperbaikan()">
                                                <i class="fas fa-plus mt-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="input-nilai-tambah">Nilai Tambah</label>
                                    <input type="text" class="form-control" id="input-nilai-tambah"
                                        placeholder="Masukkan nilai tambah" name="nilai_tambah" required>
                                </div>
                                <div class="form-group">
                                    <label for="input-keputusan">Keputusan</label>
                                    <textarea style="height: 70px;" class="form-control" id="input-keputusan" placeholder="Masukkan hasil keputusan"
                                        name="keputusan" required></textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="input-foto-video">Lampiran</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('media.*') is-invalid @enderror"
                                                name="media[]" id="customFile" multiple>
                                            <label class="custom-file-label" for="customFile">Choose
                                                file</label>
                                            @error('media.*')
                                                <div class="invalid-feedback mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="input-status">Status</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror"
                                            name="status" onchange="showkomponen()" id="input-nama-produk">
                                            <option value="4" selected>Selesai</option>
                                            <option value="5">Tidak Selesai</option>
                                        </select>
                                        {{-- <input type="text" class="form-control" id="input-status" name="status"> --}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="jawaban_id" value="{{ $jawaban_id }}" hidden>
                                    <input type="text" name="nolmlj" value="{{ $masalah->nolmlj }}" hidden>
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
@endsection
<script>
    var id = 1;

    function tambahperbaikan() {
        $('#tanggal').append(`<input type="date" class="form-control mt-2" id="input-tanggal-${id}" name="tanggal[]"
                                            required>`);
        $('#perbaikan').append(`<div style="" class="d-inline-flex mb-2 mb-2" id="div-perbaikan-${id}">
                                            <input name="perbaikan[]" type="text" class="form-control"
                                                id="input-detail-masalah-2" placeholder="Perbaikan">
                                            <a class="btn btn-icon btn-danger ml-1 text-white" id="btn-tambah-perbaikan-"
                                                onclick="kurangperbaikan(${id})">
                                                <i class="fas fa-minus mt-2"></i>
                                            </a>
                                        </div>`);

        id++;

    }

    function kurangperbaikan(id_section) {
        $(`#input-tanggal-${id_section}`).remove();
        $(`#div-perbaikan-${id_section}`).remove();
    }
</script>
