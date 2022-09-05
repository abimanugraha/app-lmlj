@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ url('kotak-keluar-lmlj') }}">Kotak Keluar LMLJ</a></div>
                    <div class="breadcrumb-item">Edit LMLJ</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit LMLJ</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('edit-masalah') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label>Unit Tujuan</label>
                                        <select class="form-control select2" name="unit_tujuan_id">
                                            @foreach ($unit as $item)
                                                @if ($item->id == $masalah->unit_tujuan_id)
                                                    <option selected value="{{ $item->id }}">{{ $item->unit }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->unit }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">Tembusan</label>
                                        <input hidden type="text" id="tembusan" value="{{ $tembusan }}">
                                        <select name="tembusan[]" class="form-control select2" multiple=""
                                            id="input-tmbsn">
                                            @foreach ($unit_tembusan as $item)
                                                <option id="option-tembusan-{{ $item->id }}"
                                                    value="{{ $item->id }}">
                                                    {{ $item->unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">Produk</label>
                                        <select name="produk_id" class="form-control select2" id="input-produk">
                                            @foreach ($produk as $item)
                                                @if ($item->id == $masalah->lmlj->produk_id)
                                                    <option selected value="{{ $item->id }}">
                                                        {{ $item->nama }} - {{ $item->nomor }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama }} - {{ $item->nomor }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">Komponen</label>
                                        <select name="komponen_id" class="form-control select2" id="input-komponen">
                                            @foreach ($komponen as $item)
                                                @if ($item->id == $masalah->komponen_id)
                                                    <option selected value="{{ $item->id }}">
                                                        {{ $item->nama }} - {{ $item->nomor }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama }} - {{ $item->nomor }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">Masalah </label>
                                        <input type="text" class="form-control @error('masalah') is-invalid @enderror"
                                            name="masalah" placeholder="Uraian singkat masalah"
                                            value="{{ $masalah->masalah }}">
                                        @error('masalah')
                                            <div class="invalid-feedback mt-2">
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">Nilai Tambah </label>
                                        <input type="text" class="form-control @error('masalah') is-invalid @enderror"
                                            name="nilai_tambah" placeholder="Nilai tambah"
                                            value="{{ $masalah->nilai_tambah }}">
                                        @error('masalah')
                                            <div class="invalid-feedback mt-2">
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-2">
                                        <label for="input-urgensi">Urgensi</label><br>
                                        <div class="selectgroup">
                                            <label class="selectgroup-item" id="input-urgensi">
                                                <input type="radio" name="urgensi" value="1"
                                                    class="selectgroup-input"
                                                    @if ($masalah->urgensi == 1) checked="" @endif>
                                                <span class="selectgroup-button">3</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="urgensi" value="2"
                                                    class="selectgroup-input"
                                                    @if ($masalah->urgensi == 2) checked="" @endif>
                                                <span class="selectgroup-button">7</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="urgensi" value="3"
                                                    class="selectgroup-input"
                                                    @if ($masalah->urgensi == 3) checked="" @endif>
                                                <span class="selectgroup-button">14</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="input-foto-video">Lampiran</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="media[]"
                                                id="customFile" multiple onchange="validasiEkstensi()">
                                            <label class="custom-file-label" id="label-customFile"
                                                for="customFile">Choose
                                                file</label>
                                            <div class="invalid-feedback mt-2">
                                                File tidak dapat diupload!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">No LMLJ </label>
                                        <input disabled type="text" class="form-control invoice-input" name="nolmlj"
                                            id="input-nolmlj">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="input-no-lmlj">Lampiran </label>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm" style="font-size:13px">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>File</th>
                                                        <th>Type</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="margin-top: 40px">
                                                    @if ($masalah->media->count() > 0)
                                                        <?php $i = 1;
                                                        $no = 1; ?>
                                                        @foreach ($masalah->media as $item)
                                                            <tr id="lampiran-{{ $item->id }}">
                                                                <td class="align-middle" scope="row">
                                                                    {{ $i++ }}</td>
                                                                <td class="align-middle">
                                                                    @if (substr($item->file, -3) == 'pdf')
                                                                        <a class="badge badge-info"
                                                                            href="{{ asset('storage/upload_media/masalah/' . $masalah->lmlj->pengaju->unit->unit . '/' . $item->file) }}"
                                                                            target="_BLANK">Lampiran {{ $no++ }}
                                                                        </a>
                                                                    @else
                                                                        <div class="gallery gallery-sm">
                                                                            <div class="gallery-item"
                                                                                data-image="{{ asset('storage/upload_media/masalah/' . $masalah->lmlj->pengaju->unit->unit . '/' . $item->file) }}"
                                                                                data-title="{{ $item->file }}">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle">
                                                                    {{ strtoupper(explode('.', $item->file)[1]) }} </td>
                                                                <td class="align-middle">
                                                                    <a href="#" class="btn btn-sm btn-danger"
                                                                        onclick="deletelampiran({{ $item->id }})">
                                                                        Hapus
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex flex-column col-6" id="detail">
                                        <label for="input-detail">Detail Masalah</label>
                                        <div class="d-inline-flex mb-2">
                                            <input autofocus="" required name="detail[]" type="text"
                                                class="form-control @error('detail.*') is-invalid @enderror"
                                                id="input-detail" placeholder="Detail masalah ">
                                            <a class="btn btn-icon btn-primary ml-1 text-white" id="btn-tambah-detail"
                                                onclick="tambahdetail()">
                                                <i class="fas fa-plus mt-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group float-right">
                                    <input type="text" hidden id="temp_nolmlj" value="{{ $masalah->nolmlj }}">
                                    <input type="text" hidden id="detailmasalah" value="{{ $detail }}">
                                    <input type="text" name="masalah_id" value="{{ $masalah->id }}" hidden>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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

    function tambahdetail() {
        $('#tanggal').append(`<input type="date" class="form-control mt-2" id="input-tanggal-${id}" name="tanggal[]"
                                            required>`);
        $('#detail').append(`<div style="" class="d-inline-flex mb-2 mb-2" id="div-detail-${id}">
                                            <input name="detail[]" type="text" class="form-control"
                                                id="input-detail-${id}" placeholder="Detail masalah">
                                            <a class="btn btn-icon btn-danger ml-1 text-white" id="btn-tambah-detail-${id}"
                                                onclick="kurangdetail(${id})">
                                                <i class="fas fa-minus mt-2"></i>
                                            </a>
                                        </div>`);
        id++;
    }

    function kurangdetail(id_section) {
        $(`#input-tanggal-${id_section}`).remove();
        $(`#div-detail-${id_section}`).remove();
    }

    function deletelampiran(id) {
        swal({
                title: 'Anda yakin?',
                text: 'Sekali menghapus, lampiran ini tidak akan bisa diakses kembali!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // console.log(id);
                    $.ajax({
                        url: `{{ url('ajax/delete-lampiran') }}` + `/` + id,
                        success: function(res) {
                            swal('Lampiran ' + res.file + ' berhasil dihapus!', {
                                icon: 'success',
                            });
                            console.log($('#lampiran-' + res.id));
                            $('#lampiran-' + res.id).remove();
                        }
                    });
                } else {}
            });
    }

    function updatetembusan() {
        $("#input-tmbsn").children().remove();
        $.ajax({
            url: `{{ url('ajax/unittembusan') }}` + `/` + {{ auth()->user()->unit->id }},
            contentType: 'application/json',
            dataType: 'json',
            data: data,
            success: function(res) {
                $.each(res, function(index, data) {
                    $("#input-tmbsn").append(
                        `<option value="${data.id}">${data.unit}</option>`)
                });
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        var array = JSON.parse($('#tembusan').val());
        array.forEach(item => {
            let test = $(`#option-tembusan-${item}`).attr("selected", "selected");
        });

        var detail = JSON.parse($('#detailmasalah').val());
        $('#input-detail').val(detail[0].detail);
        for (var i = 1; i < detail.length; i++) {
            tambahdetail();
            $('#input-detail-' + i).val(detail[i].detail);
        }

        var nolmlj = $('#temp_nolmlj').val();
        var length = nolmlj.length - 1;
        var cleaveI = new Cleave('.invoice-input', {
            prefix: nolmlj.substr(0, length),
            blocks: [length, 1],
            uppercase: true,
        });
        $('#input-nolmlj').val(nolmlj);

    });

    function validasiEkstensi() {
        var inputFile = document.getElementById(`customFile`);
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
        if (!ekstensiOk.exec(pathFile)) {
            inputFile.value = '';
            $(`#customFile`).attr('class', 'custom-file-input is-invalid');
            $(`#label-customFile`).html('Choose File');
            return false;
        } else {
            var numFiles = $(`#customFile`)[0].files.length;
            $(`#customFile`).attr('class', 'custom-file-input');
            $(`#label-customFile`).html(numFiles + ' file terpilih');
        }
    }
</script>
