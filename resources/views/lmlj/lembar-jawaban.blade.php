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
                    <div class="breadcrumb-item"><a href="{{ url('kotak-masuk-lmlj') }}">Kotak Masuk LMLJ</a></div>
                    <div class="breadcrumb-item">Lembar Jawaban</div>
                </div>
            </div>
            <div class="row">
                @include('section.masalah')
                {{-- Lembar Jawaban LMLJ --}}
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lembar Jawaban</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('lembar-jawaban') }}" method="post">
                                @csrf
                                <div class="form-group d-flex flex-column">
                                    <label for="input-detail-masalah">Analisa</label>
                                    <div class="d-inline-flex mb-2">
                                        <input autofocus="" required name="analisa[]" type="text"
                                            class="form-control @error('analisa.*') is-invalid @enderror"
                                            id="input-detail-masalah" placeholder="Analisa masalah">
                                        <a class="btn btn-icon btn-primary ml-1 text-white" id="btn-tambah-detail-1"
                                            onclick="tampildetail(1)">
                                            <i class="fas fa-plus mt-2"></i>
                                        </a>
                                    </div>
                                    @error('analisa.*')
                                        <div class="invalid-feedback mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div style="display: none;" class="mb-2" id="div-detail-2">
                                        <input disabled name="analisa[]" type="text" class="form-control"
                                            id="input-detail-masalah-2" placeholder="Analisa masalah">
                                        <a class="btn btn-icon btn-danger ml-1 text-white" id="btn-tambah-detail-2"
                                            onclick="tampildetail(2)">
                                            <i class="fas fa-minus mt-2"></i>
                                        </a>
                                    </div>
                                    <div style="display: none;" class="mb-2" id="div-detail-3">
                                        <input disabled name="analisa[]" type="text" class="form-control"
                                            id="input-detail-masalah-3" placeholder="Analisa masalah">
                                        <a class="btn btn-icon btn-danger ml-1 text-white" id="btn-tambah-detail-3"
                                            onclick="tampildetail(3)">
                                            <i class="fas fa-minus mt-2"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="input-target">Target Penyelesaian</label>
                                        <input type="number" class="form-control" id="input-target" name="target"
                                            required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <div class="mt-4"></div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check-teruskan"
                                                name="forward">
                                            <label class="form-check-label" for="check-teruskan">
                                                Teruskan?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="input-unit-tujuan">Unit Tujuan</label>
                                        <select class="form-control select2 @error('unit_id') is-invalid @enderror"
                                            name="forward_unit[]" id="input-unit-tujuan" multiple disabled>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_tujuan_id')
                                            <div class="invalid-feedback mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        {{-- <label for="input-unit-tujuan">Unit Tujuan</label>
                                        <input required type="text" name="unit_id" class="form-control"
                                            id="input-unit-tujuan" disabled> --}}
                                    </div>
                                </div>
                                <div class="form-row">
                                    <input type="text" hidden name="nolmlj" value="{{ $masalah->nolmlj }}">

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
            var x = $("#check-teruskan").is(":checked");
            if (x) {
                document.getElementById('input-unit-tujuan').disabled = false;
            } else {
                document.getElementById('input-unit-tujuan').disabled = true;
            }
        }
    </script>
@endsection
