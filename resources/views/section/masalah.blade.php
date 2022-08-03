{{-- Lembar Masalah --}}
<div class="col-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>Lembar Masalah</h4>
            <div class="card-header-action">
                {{ $masalah->created_at->format('d-M-Y') }}
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-10 col-md-10 col-lg-10">
                    <button type="button" class="btn btn-light">
                        <h4 class="mt-2">{{ $masalah->nolmlj }}</h4>
                    </button>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    @if ($masalah->status == 4)
                        <figure class="avatar mr-2 avatar-lg bg-{{ $masalah->color_realisasi }} text-white"
                            data-initial="{{ $masalah->created_at->diffInDays($masalah->updated_at) }}">
                        </figure>
                    @else
                        <figure class="avatar mr-2 avatar-lg bg-{{ $masalah->color_urgensi }} text-white"
                            data-initial="{{ $masalah->target }}">
                        </figure>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-1">
                        <div class="col mb-0">
                            Nama produk <b class="text-dark">{{ $masalah->lmlj->produk->nama }}</b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            Nomor produk <b class="text-dark">{{ $masalah->lmlj->produk->nomor }}</b>
                        </div>
                    </div>
                    <div class="row mb-1" id="input-nama-komponen">
                        <div class="col">
                            Nama Komponen
                            @if ($masalah->komponen)
                                <b class="text-dark" id="nama-komponen">
                                    {{ $masalah->komponen->nama }}
                                </b>
                                @if ($masalah->komponen->history->count() >= 1)
                                    diganti
                                    <b class="text-dark">
                                        {{ $masalah->komponen->history->first()->komponenbaru->nama }}
                                    </b>
                                @endif
                                @if ($masalah->status < 4 &&
                                    ($masalah->unit_tujuan_id == auth()->user()->unit->id ||
                                        $masalah->lmlj->unit_pengaju_id == auth()->user()->unit->id))
                                    <a href="#" id="modal-5">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            @else
                                @if ($masalah->status < 4 &&
                                    ($masalah->unit_tujuan_id == auth()->user()->unit->id ||
                                        $masalah->lmlj->unit_pengaju_id == auth()->user()->unit->id))
                                    <a href="#" id="modal-5">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            Nomor Komponen
                            <b class="text-dark" id="nomor-komponen">
                                @if ($masalah->komponen)
                                    {{ $masalah->komponen->nomor }}
                                @endif
                            </b>
                            @if ($masalah->komponen)
                                @if ($masalah->komponen->history->count() == 1)
                                    diganti
                                    <b class="text-dark">
                                        {{ $masalah->komponen->history->first()->komponenbaru->nomor }}
                                    </b>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            Masalah <b class="text-dark">{{ $masalah->masalah }}</b>
                        </div>
                    </div>
                    @if ($masalah->media->count() > 0)
                        <div class="row mb-1">
                            <div class="col">
                                Foto/Video
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-4 text-right">
                    @if ($masalah->status == 4)
                        <figure>
                            <img src="{{ asset('assets/img/solved.png') }}" alt="status" style="width:80%">
                            <figcaption>{{ $masalah->updated_at->format('d-M-Y') }}</figcaption>
                        </figure>
                    @endif
                </div>
            </div>
            @if ($masalah->media->count() > 0)
                <div class="row mb-1">
                    <div class="col">
                        <div class="gallery gallery-md">
                            @foreach ($masalah->media as $item)
                                <div style="border: 2px solid #cdd3d8;" class="gallery-item"
                                    data-image="{{ asset('upload_media/masalah/' . $masalah->lmlj->pengaju->unit->unit . '/' . $item->file) }}"
                                    data-title="{{ $item->file }}"></div>
                            @endforeach
                            {{-- <div class="gallery-item" data-image="{{ asset('assets/img/news/img02.jpg') }}"
                            data-title="Image 2"></div>
                        <div class="gallery-item" data-image="{{ asset('assets/img/news/img03.jpg') }}"
                            data-title="Image 3"></div>
                        <div class="gallery-item" data-image="{{ asset('assets/img/news/img04.jpg') }}"
                            data-title="Image 4"></div>
                        <div class="gallery-item gallery-more" data-image="{{ asset('assets/img/news/img05.jpg') }}"
                            data-title="Image 12">
                            <div>+2</div>
                        </div> --}}
                        </div>
                    </div>
                </div>
            @endif
            @if ($detail_masalah)
                <div class="row mb-1">
                    <div class="col">
                        Detail Masalah
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col">
                        @foreach ($detail_masalah as $item)
                            <p class="text-dark">{{ $number++ }}. {{ $item->detail }}
                            </p>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($masalah->nilai_tambah)
                <div class="row mb-1">
                    <div class="col">
                        Nilai Tambah
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col">
                        <p class="text-dark"><i class="fas fa-caret-right"></i>
                            {{ $masalah->nilai_tambah }}
                        </p>
                    </div>
                </div>
            @endif
            @if ($masalah->lmlj->tembusan->count() > 0)
                <div class="row mb-1">
                    <div class="col">
                        List CC
                    </div>
                </div>
                @foreach ($masalah->lmlj->tembusan as $item)
                    <div class="row mb-1">
                        <div class="col">
                            <p class="text-dark"><i class="fas fa-caret-right"></i>
                                {{ $item->unit->unit }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="row mb-1 mt-3">
                <div class="col text-center">
                    @if ($masalah->status >= 1)
                        <div class="row mb-2">
                            <div class="col">Diketahui</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <figure class="avatar mr-2 avatar-lg bg-light text-dark"
                                    data-initial="{{ substr($masalah->lmlj->diketahui->nama, 0, 1) }}">
                                </figure>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col text-dark">{{ $masalah->lmlj->diketahui->nama }}</div>
                        </div>
                    @elseif(auth()->user()->role_id == 2 && $masalah->status == 0)
                        <div class="row mb-2">
                            <div class="col">Diketahui</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" onclick="konfirmasimasalah({{ $masalah->id }})"
                                    class="btn btn-success">Konfirmasi
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col text-center">
                    <div class="row mb-2">
                        <div class="col">Pengaju</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <figure class="avatar mr-2 avatar-lg bg-light text-dark"
                                data-initial="{{ substr($masalah->lmlj->pengaju->nama, 0, 1) }}"></figure>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-dark">{{ $masalah->lmlj->pengaju->nama }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form class="modal-part" id="modal-login-part">
    <div class="form-group">
        <label>Nama Komponen</label>
        <select required class="form-control select2" name="komponen_id" id="input-nama-komponen"
            onchange="editkomponen(this.value)">
            <option value="" selected>Pilih Komponen</option>
            @foreach ($masalah->lmlj->produk->komponen as $item)
                <option value="{{ $item->id }},{{ $item->nama }}">{{ $item->nama }}</option>
            @endforeach
        </select>
        <input type="text" class="form-control" id="id-komponen" name="id" hidden>
        <input type="text" class="form-control" id="h-nama-komponen" name="nama" hidden>
        <input type="text" class="form-control" value="{{ $masalah->id }}" name="masalah_id" hidden>

    </div>
    <div class="form-group">
        <label>Nomor Komponen</label>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Nomor Komponen" name="nomor"
                id="input-nomor-komponen">
        </div>
    </div>
</form>
<script>
    function konfirmasimasalah(id) {
        $.ajax({
            url: `{{ url('ajax/konfirmasi') }}` + `/` + id,
            success: function(res) {
                console.log(res);
                window.location.href = `{{ url('ajax/konfirmasi-done') }}` + `/` + res;
            }
        });
    }

    function editkomponen(komponen_id) {
        var array = komponen_id.split(",");
        console.log(array[1]);
        $("#id-komponen").val(array[0]);
        $("#h-nama-komponen").val(array[1]);
        $.ajax({
            url: `{{ url('ajax/komponenbyid') }}` + `/` + komponen_id,
            success: function(res) {
                $("#input-nomor-komponen").val(res.nomor);
            }
        });
    }
</script>
