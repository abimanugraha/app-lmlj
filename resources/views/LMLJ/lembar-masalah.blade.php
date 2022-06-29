@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">Lembar Masalah</h2>
                <p class="section-lead">Isi lembar masalah untuk mengajukan LMLJ</p>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Lembar Masalah</h4>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="input-no-lmlj">Nomor LMLJ </label>
                                        <input type="text" class="form-control" name="input_nolmlj"
                                            value="{{ $nolmlj }}" disabled>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="input-nama-produk">Nama Produk</label>
                                            <select class="form-control select2" name="input_nama_produk"
                                                onchange="showkomponen()" id="input-nama-produk">
                                                @foreach ($produk as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="input-nomor-produk">Nomor Produk</label>
                                            <select class="form-control select2" name="input_nomor_produk">
                                                {{-- @foreach ($produk as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="input-nama-komponen">Nama Komponen</label>
                                            <select class="form-control select2" name="input_nomor_produk"
                                                id="input-nama-komponen">

                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="input-nomor-komponen">Nomor Komponen</label>
                                            <input type="text" class="form-control" id="input-nomor-komponen">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="input-unit-tujuan">Unit Tujuan</label>
                                            <input type="text" class="form-control" id="input-unit-tujuan">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="input-unit-pengaju">Unit Pengaju</label>
                                            <input type="text" class="form-control" id="input-unit-pengaju">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="input-urgensi">Urgensi</label>
                                            <input type="text" class="form-control" id="input-urgensi">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="input-foto-video">Foto/Video</label>
                                            <input type="file" class="form-control" id="input-foto-video">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-detail-masalah">Detail Masalah</label>
                                        <textarea class="form-control" id="input-detail-masalah" rows="3" placeholder="Masukkan detail masalah"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-nilai-tambah">Nilai Tambah</label>
                                        <input type="text" class="form-control" id="input-nilai-tambah" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-nama-pengaju">Nama Pengaju</label>
                                        <input type="text" class="form-control" id="input-nama-pengaju" placeholder="">
                                    </div>
                                    <div class="form-group float-right">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script type="text/javascript">
    function showkomponen() {
        var e_produk = document.getElementById("input-nama-produk").value;
        /*
        
        */
    }
</script>
