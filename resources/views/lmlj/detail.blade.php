@extends('layout/main')

@section('content')
    <style>
        p {
            margin-bottom: 0;
        }

        figcaption {
            rotate: -9deg;
            margin-top: -10%;
            margin-right: 10%;
            size: 80%;
            color: rgb(243, 44, 44);
        }


        .progressbar {
            counter-reset: step;
            margin-inline-start: -7%;
            margin-bottom: 0;
        }

        .progressbar li {
            /* list-style: none; */
            display: inline-block;
            width: {{ $lebar_status }};
            position: relative;
            text-align: center;
            /* cursor: pointer; */
        }

        .progressbar li:before {
            content: '';
            /* padding: 5%; */
            counter-increment: step;
            width: 25px;
            height: 25px;
            line-height: 25px;
            /* border: 1px solid #47c363; */
            border-radius: 100%;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            background-color: #cdd3d8;
        }

        .progressbar li:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: #ddd;
            top: 12.5px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {
            color: #47c363;

        }

        .progressbar li.active:before {
            border: 2px solid #47c363;
        }

        .progressbar li.active+li:after {
            background-color: #47c363;
        }
    </style>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
                <div class="section-header-breadcrumb">
                    @if (url()->previous() == url('lmlj-selesai'))
                        <div class="breadcrumb-item"><a href="{{ url()->previous() }}">LMLJ Selesai</a></div>
                    @else
                        <div class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></div>
                    @endif
                    <div class="breadcrumb-item">Detail</div>
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
                {{-- Lembar Jawaban --}}
                @include('section/masalah')

                {{-- Status Progress LMLJ --}}
                <div class="col-12 col-md-6 col-lg-6">
                    <h2 class="section-title">Status LMLJ</h2>
                    @if ($masalah->lmlj->spv_pengaju_id)
                        @if ($jawaban->count() > 0)
                            <div class="row">
                                <div class="col text-center">
                                    <ul class="progressbar">
                                        <li class="active">{{ $masalah->lmlj->pengaju->unit->unit }}</li>
                                        @foreach ($jawaban as $item)
                                            <li class="active">{{ $item->penerima->unit->unit }}</li>
                                        @endforeach
                                        @if ($item->status < 4)
                                            @foreach ($masalah->forward as $forward)
                                                @if ($forward->unit->unit != $item->penerima->unit->unit && $forward->status == 0)
                                                    <li class="">{{ $forward->unit->unit }}</li>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($jawaban->count() == 0)
                                            <li class="">{{ $masalah->unit->unit }}</li>
                                        @else
                                            @if ($masalah->status == 4)
                                                <li class="active">Selesai</li>
                                            @else
                                                <li class="">Selesai</li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-light alert-has-icon">
                                <div class="alert-icon"><i class="fas fa-spinner"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Menunggu respon {{ $masalah->unit->unit }}!</div>
                                    Hubungi unit tujuan!
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-light alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Menunggu Konfirmasi</div>
                                Hubungi kanit atau pihak terkait yang harus mengetahui lembar masalah ini!
                            </div>
                        </div>
                    @endif

                    @foreach ($jawaban as $item)
                        <div class="row mt-3">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Lembar Jawaban</h4>
                                        <div class="card-header-action">
                                            {{ $item->created_at->format('d-M-Y') }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                Unit
                                                <h4 class="text-dark">{{ $item->penerima->unit->unit }}</h4>
                                            </div>
                                            <div class="col-4 text-center">
                                                <figure
                                                    class="avatar mt-1 avatar-md bg-{{ $item->color_urgensi }} text-white"
                                                    data-initial="{{ $item->target }}">
                                                </figure><br>
                                                <a data-toggle="collapse" href="#detailjawaban{{ $item->id }}"
                                                    id="btn-detail-jawaban-{{ $item->id }}"
                                                    class="badge badge-{{ $item->color_status }} mt-2"
                                                    onclick="show({{ $item->id }})">
                                                    {{ $item->text_status }}
                                                    <span><i class="fas fa-angle-down"></i></span>
                                                </a>
                                            </div>
                                            <div class="col-4 text-right">
                                                <div class="row mb-2">
                                                    <div class="col">Penerima</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <figure class="avatar mr-2 avatar-sm bg-light text-dark"
                                                            data-initial="{{ substr($item->penerima->nama, 0, 1) }}">
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col text-dark">{{ $item->penerima->nama }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse" id="detailjawaban{{ $item->id }}">
                                            <div class="row mt-2">
                                                <div class="col">
                                                    Analisa Masalah
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    @php $number = 1; @endphp
                                                    @foreach ($item->analisas as $analisa)
                                                        <p class="text-dark">{{ $number++ }}.
                                                            {{ $analisa->analisa }}
                                                        </p>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if ($item->keputusan)
                                                @if ((auth()->user()->role_id == 2 && $item->unit_id == auth()->user()->unit->id) ||
                                                    $item->unit_id == auth()->user()->unit->id ||
                                                    $item->status == 4)
                                                    <div class="row">
                                                        <div class="col">
                                                            Perbaikan
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            @php $number = 1; @endphp
                                                            @foreach ($item->perbaikan as $perbaikan)
                                                                <p class="text-dark">{{ $number++ }}.
                                                                    <b>{{ $perbaikan->created_at->format('d-M-Y') }}</b>
                                                                    <i class="fas fa-long-arrow-alt-right"></i>
                                                                    {{ $perbaikan->perbaikan }}
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            Nilai Tambah
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            @php $number = 1; @endphp
                                                            <p class="text-dark">1. {{ $item->nilai_tambah }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            Keputusan
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p class="text-dark">1. {{ $item->keputusan }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if ($item->media->count() > 0)
                                                        <div class="row">
                                                            <div class="col">
                                                                Lampiran
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col">
                                                                <div class="gallery gallery-md">
                                                                    @foreach ($item->media as $media)
                                                                        <div style="border: 2px solid #cdd3d8;"
                                                                            class="gallery-item"
                                                                            data-image="{{ asset('upload_media/jawaban/' . $masalah->lmlj->pengaju->unit->unit . '/' . $media->file) }}"
                                                                            data-title="Image 1"></div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="row mb-1 mt-3">
                                                    <div class="col text-center">
                                                        @if ($item->status >= 1)
                                                            {{ $item->updated_at->format('d, M Y') }}
                                                            <div class="row mb-2">
                                                                <div class="col">Diketahui
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <figure
                                                                        class="avatar mr-2 avatar-lg bg-light text-dark"
                                                                        data-initial="{{ substr($masalah->lmlj->diketahui->nama, 0, 1) }}">
                                                                    </figure>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col text-dark">
                                                                    {{ $masalah->lmlj->diketahui->nama }}
                                                                </div>
                                                            </div>
                                                        @elseif(auth()->user()->role_id == 2 && $item->unit_id == auth()->user()->unit->id && $item->status == 0)
                                                            <div class="row mb-2">
                                                                <div class="col">Diketahui
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <a href="#"
                                                                        onclick="konfirmasijawaban({{ $item->id }})"
                                                                        class="btn btn-success">Konfirmasi
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col text-center">
                                                        <div class="row mb-2 mt-4">
                                                            <div class="col">PIC</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <figure class="avatar mr-2 avatar-lg bg-light text-dark"
                                                                    data-initial="{{ substr($item->pic->nama, 0, 1) }}">
                                                                </figure>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col text-dark">
                                                                {{ $item->pic->nama }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="card-footer text-center">
                                        <a data-toggle="collapse" href="#detailjawaban" id="btn-detail-jawaban"
                                            class="btn btn-icon btn-secondary">
                                            <i class="fas fa-angle-down"></i>
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- {{ dd($masalah->forward) }} --}}
                    @if ($masalah->forward->count() > 0)
                        @foreach ($masalah->forward as $forward)
                            @if ($forward->status == 0)
                                <div class="alert alert-light alert-has-icon">
                                    <div class="alert-icon"><i class="fas fa-spinner"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Masalah diforward ke Unit :
                                            @foreach ($masalah->forward as $data)
                                                {{ $data->unit->unit }}
                                            @endforeach
                                        </div>
                                        Hubungi unit tujuan!
                                    </div>
                                </div>
                                <?php break; ?>
                            @endif
                        @endforeach
                    @endif


                </div>
            </div>
        </section>
    </div>

    <script>
        function show($id) {
            $('#btn-detail-jawaban-' + $id).find("i").toggleClass("fa-angle-down fa-angle-up");
        }

        function konfirmasijawaban(id) {
            $.ajax({
                url: `{{ url('ajax/konfirmasijawaban') }}` + `/` + id,
                success: function(res) {
                    console.log(res);
                    window.location.href = `{{ url('ajax/konfirmasi-jawaban-done') }}` + `/` + res;
                }
            });
        }
    </script>
@endsection
