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
                            <form>
                                <div class="form-group">
                                    <label for="input-perbaikan">Perbaikan Masalah</label>
                                    <textarea style="height: 70px;" class="form-control" id="input-perbaikan" placeholder="Masukkan detail masalah"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="input-nilai-tambah">Nilai Tambah</label>
                                    <input type="text" class="form-control" id="input-nilai-tambah" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="input-keputusan">Keputusan</label>
                                    <textarea style="height: 70px;" class="form-control" id="input-keputusan" placeholder="Masukkan detail masalah"></textarea>
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
                                    <input type="text" class="form-control" id="input-nama-pembuat" placeholder="">
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
