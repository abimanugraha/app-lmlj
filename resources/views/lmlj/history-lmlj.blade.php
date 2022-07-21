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
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>History LMLJ</h4>
                                <div class="card-header-action dropdown">
                                    {{-- <input class="daterangepicker-field"> --}}
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Produk
                                        </button>
                                        <div class="dropdown-menu">
                                            <input type="text" class="form-control-sm" placeholder="Search">
                                            {{-- <a class="dropdown-item has-icon" href="#"><i class="far fa-heart"></i>
                                                Action</a>
                                            <a class="dropdown-item has-icon" href="#"><i class="far fa-file"></i>
                                                Another action</a>
                                            <a class="dropdown-item has-icon" href="#"><i class="far fa-clock"></i>
                                                Something else here</a> --}}
                                        </div>
                                    </div>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Unit
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    <button class="btn btn-light icon-left btn-icon daterangepicker-field ml-2">
                                        <i class="fas fa-calendar"></i> Choose Date
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right datas">
                                        <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                            Electronic</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                            T-shirt</a>
                                        <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                            Hat</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="badges" id="filtered">

                                </div>
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
                                                            <td class="align-middle">
                                                                {{ $item->updated_at->format('d-M-Y') }}
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
                                                                            data-image="{{ asset('upload_media/masalah/' . $item->pengaju->unit->unit . '/' . $item->media[0]->file) }}"
                                                                            data-title="Foto Masalah"></div>
                                                                    </div>
                                                                @else
                                                                    <img src="assets/img/warning.png" alt=""
                                                                        width="50">
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
