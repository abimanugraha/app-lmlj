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
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a href="{{ url('lmlj-selesai') }}">
                            <div class="card-icon bg-success">
                                <i class="far fa-file-alt"></i>
                            </div>
                        </a>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>LMLJ Selesai</h4>
                            </div>
                            <div class="card-body">
                                {{ $selesai }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <a href="#">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </a>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>LMLJ Proses</h4>
                            </div>
                            <div class="card-body">
                                {{ $proses }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-folder-open"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total LMLJ</h4>
                            </div>
                            <div class="card-body">
                                {{ $total }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar LMLJ Dalam Proses</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>Tanggal</th>
                                            <th>Nomor LMLJ</th>
                                            <th>Unit Pengaju</th>
                                            <th>Unit Tujuan</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lmlj_proses as $item)
                                            <tr>
                                                <td>
                                                    {{ $number++ }}
                                                </td>
                                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">
                                                    <div class="badge badge-secondary text-dark">
                                                        {{ $item->nolmlj }}
                                                    </div>
                                                </td>
                                                <td>{{ $item->pengaju->unit->unit }}</td>
                                                <td>{{ $item->unit->unit }}</td>
                                                <td>
                                                    <figure
                                                        class="avatar mr-2 avatar-sm bg-{{ $item->color }} text-white"
                                                        data-initial="{{ $item->target }}"></figure>
                                                </td>
                                                <td>
                                                    <div class="badge badge-{{ $item->color_status }}">
                                                        {{ $item->text_status }}</div>
                                                </td>
                                                <td><a href="{{ url('detail/' . $item->nolmlj) }}"
                                                        class="btn btn-primary">Detail</a></td>
                                            </tr>
                                        @endforeach

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
