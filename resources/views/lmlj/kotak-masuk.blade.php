@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
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
                            <h4>Kotak Masuk LMLJ</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Tanggal</th>
                                            <th>Nomor LMLJ</th>
                                            <th>Masalah</th>
                                            <th>Foto</th>
                                            <th>Pengirim</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($masalah) > 0)
                                            @foreach ($masalah as $item)
                                                @if ($item->status != 0 || auth()->user()->role_id == 2)
                                                    <tr>
                                                        <td class="align-middle">{{ $number++ }}</td>
                                                        <td class="align-middle">{{ $item->updated_at->format('d-M-Y') }}
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="badge badge-secondary text-dark">
                                                                {{ $item->nolmlj }}
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">{{ $item->masalah }}</td>
                                                        <td class="align-middle">
                                                            @if ($item->media->count() > 0)
                                                                <div class="gallery gallery-sm">
                                                                    <div style="border: 2px solid #cdd3d8;"
                                                                        class="gallery-item"
                                                                        data-image="{{ asset('storage/upload_media/masalah/' . $item->pengaju->unit->unit . '/' . $item->media[0]->file) }}"
                                                                        data-title="Foto Masalah"></div>
                                                                </div>
                                                            @else
                                                                <img src="{{ asset('assets/img/warning.png') }}"
                                                                    alt="" width="50">
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{ $item->pengaju->unit->unit }}</td>
                                                        <td class="align-middle">
                                                            @if ($item->status == 0 && auth()->user()->role_id == 2)
                                                                <a href="{{ url('detail/' . $item->nolmlj) }}"
                                                                    class="btn btn-primary">Konfirmasi
                                                                </a>
                                                            @else
                                                                <a href="{{ url('lembar-jawaban/' . $item->nolmlj) }}"
                                                                    class="btn btn-success">Jawab
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        {{-- @foreach ($masalah as $item)
                                            <tr>
                                                <td>{{ $number++ }}</td>
                                                <td>{{ $item->updated_at->format('d-M-Y') }}</td>
                                                <td class="align-middle">
                                                    <div class="badge badge-secondary text-dark">
                                                        {{ $item->nolmlj }}
                                                    </div>
                                                </td>
                                                <td>{{ $item->masalah }}</td>
                                                <td>
                                                    <img src="assets/img/warning.png" alt="masalah" width="50">
                                                </td>
                                                <td>{{ $item->pengaju->unit->unit }}</td>
                                                <td><a href="{{ url('lembar-jawaban/' . $item->nolmlj) }}"
                                                        class="btn btn-success">Jawab</a>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                        {{-- <tr>
                                            <td>1</td>
                                            <td>2022-06-01</td>
                                            <td class="align-middle">
                                                <div class="badge badge-secondary text-dark">
                                                    UNIT-LMLJ/06/22/001
                                                </div>
                                            </td>
                                            <td>Lorem ipsum</td>
                                            <td>
                                                <img src="assets/img/warning.png" alt="masalah" width="50">
                                            </td>
                                            <td>Unit Pengaju</td>
                                            <td><a href="{{ url('lembar-jawaban') }}" class="btn btn-success">Jawab</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2022-06-01</td>
                                            <td class="align-middle">
                                                <div class="badge badge-secondary text-dark">
                                                    UNIT-LMLJ/06/22/001
                                                </div>
                                            </td>
                                            <td>Lorem ipsum</td>
                                            <td>
                                                <img src="assets/img/warning.png" alt="masalah" width="50">
                                            </td>
                                            <td>Unit Pengaju</td>
                                            <td><a href="{{ url('lembar-jawaban') }}" class="btn btn-success">Jawab</a>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
