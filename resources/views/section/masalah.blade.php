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
                        <figure class="avatar mr-2 avatar-lg bg-danger text-white"
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
                            Nama produk <b class="text-dark">{{ $masalah->produk->nama }}</b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            Nomor produk <b class="text-dark">{{ $masalah->produk->nomor }}</b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            Nama Komponen <b class="text-dark">
                                @if ($masalah->komponen)
                                    {{ $masalah->komponen->nama }}
                                @endif
                            </b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            Nomor Komponen <b class="text-dark">
                                @if ($masalah->komponen)
                                    {{ $masalah->komponen->nomor }}
                                @endif
                            </b>
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
                            <img src="{{ url('assets/img/solved.png') }}" alt="status" style="width:80%">
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
                                {{-- <video width="100" height="78" controls>
                                <source
                                    src="{{ url('upload_media/masalah/' . $masalah->pengaju->unit->unit . '/' . $item->file) }}"
                                    type="video/mp4">
                            </video> --}}
                                <div style="border: 2px solid #cdd3d8;" class="gallery-item"
                                    data-image="{{ url('upload_media/masalah/' . $masalah->pengaju->unit->unit . '/' . $item->file) }}"
                                    data-title="{{ $item->file }}"></div>
                            @endforeach
                            {{-- <div class="gallery-item" data-image="{{ url('assets/img/news/img02.jpg') }}"
                            data-title="Image 2"></div>
                        <div class="gallery-item" data-image="{{ url('assets/img/news/img03.jpg') }}"
                            data-title="Image 3"></div>
                        <div class="gallery-item" data-image="{{ url('assets/img/news/img04.jpg') }}"
                            data-title="Image 4"></div>
                        <div class="gallery-item gallery-more" data-image="{{ url('assets/img/news/img05.jpg') }}"
                            data-title="Image 12">
                            <div>+2</div>
                        </div> --}}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mb-1">
                <div class="col">
                    Detail Masalah
                </div>
            </div>
            <div class="row mb-1">
                <div class="col">
                    {{-- {{ dd($detail_masalah) }} --}}
                    @foreach ($detail_masalah as $item)
                        <p class="text-dark">{{ $number++ }}. {{ $item->detail }}
                        </p>
                    @endforeach
                    {{-- <p class="text-dark">2. Lorem ipsum dolor sit, amet consectetur adipisicing elit. A
                                        minus est dolorem cupiditate consectetur excepturi nemo magnam quae corrupti ullam?
                                    </p> --}}
                </div>
            </div>
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
                    {{-- <p class="text-dark">2. Lorem ipsum dolor sit, amet consectetur adipisicing elit. A
                                        minus est dolorem cupiditate consectetur excepturi nemo magnam quae corrupti ullam?
                                    </p> --}}
                </div>
            </div>
            <div class="row mb-1 mt-3">
                <div class="col text-center">
                    @if ($masalah->ygmengetahui_id)
                        <div class="row mb-2">
                            <div class="col">Diketahui</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <figure class="avatar mr-2 avatar-lg bg-light text-dark"
                                    data-initial="{{ substr($masalah->diketahui->nama, 0, 1) }}">
                                </figure>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col text-dark">{{ $masalah->diketahui->nama }}</div>
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
                                data-initial="{{ substr($masalah->pengaju->nama, 0, 1) }}"></figure>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-dark">{{ $masalah->pengaju->nama }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
