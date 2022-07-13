@extends('layout/main')
<style>
    .scrolling-wrapper {
        display: flex;
        overflow-x: auto;
    }

    .card-item {
        min-width: 50%;
        min-height: 100%;
    }
</style>
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
            </div>
            <div class="section-body">
                <form action="{{ url('pengajuan-lmlj') }}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Lembar Masalah</h4>
                                    <div class="card-header-action">
                                        <h6 class="text-primary">
                                            {{ $nolmlj }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @csrf
                                    {{-- Input Awal --}}
                                    <div class="form-row">
                                        <input type="text" name="nolmlj" value={{ $nolmlj }} hidden>
                                        <div class="form-group col-3">
                                            <label for="input-unit-tujuan">Unit Tujuan</label>
                                            <select class="form-control select2 @error('unit_id') is-invalid @enderror"
                                                name="unit_id[]" onchange="getunittembusan()" id="input-unit-tujuan"
                                                multiple>
                                                @foreach ($unit as $item)
                                                    <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <div class="invalid-feedback mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="input-unit-pengaju">Tembusan</label>
                                            <select name="forward[]" class="form-control select2" multiple=""
                                                id="input-tembusan" disabled>
                                            </select>
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="input-nama-produk">Nama Produk</label>
                                            <select class="form-control select2" name="produk_id" onchange="showkomponen()"
                                                id="input-nama-produk" required>
                                                <option value="0" selected>Pilih Produk</option>
                                                @foreach ($produk as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('produk_id')
                                                <div class="invalid-feedback mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="input-nomor-produk">Nomor Produk</label>
                                            <select class="form-control select2" name="" disabled
                                                id="input-nomor-produk">
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display: block;">
                        <div class="scrolling-wrapper" id="form-masalah">

                        </div>
                    </div>

                    <div class="row" id="button-kirim-lmlj">

                    </div>

                </form>

            </div>
        </section>
    </div>
@endsection
@include('script.script-lembar-masalah')
