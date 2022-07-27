@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                                    {{-- <div class="dropdown d-inline">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Produk
                                        </button>
                                        <div class="dropdown-menu">
                                            <input type="text" class="form-control-sm" placeholder="Search">
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
                                    </div> --}}
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
                                    <table class="table table-striped" id="table-history">
                                        <thead>
                                            <tr>
                                                <th hidden>tanggal</th>
                                                <th class="text-center">No</th>
                                                <th>Tanggal</th>
                                                <th>Nomor LMLJ</th>
                                                <th>Unit Pengaju</th>
                                                <th>Unit Tujuan</th>
                                                <th>Produk</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($masalah) > 0)
                                                @foreach ($masalah as $item)
                                                    @if ($item->status != 0 || auth()->user()->role_id == 2)
                                                        <tr>
                                                            <td hidden>{{ $item->created_at->format('Y-m-d') }}</td>
                                                            <td class="align-middle">{{ $number++ }}</td>
                                                            <td class="align-middle">
                                                                {{ $item->created_at->format('d-M-Y') }}
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="badge badge-secondary text-dark">
                                                                    {{ $item->nolmlj }}
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">{{ $item->lmlj->pengaju->unit->unit }}
                                                            </td>
                                                            <td class="align-middle">{{ $item->unit->unit }}</td>
                                                            <td class="align-middle">
                                                                {{ $item->lmlj->produk->nama }}
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="badge badge-{{ $item->color_status }}">
                                                                    {{ $item->text_status }}
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                <a href="{{ url('detail/' . $item->nolmlj) }}"
                                                                    class="btn btn-primary">Detail
                                                                </a>
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
