@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">LMLJ Selesai</div>
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
                            <h4>Daftar LMLJ</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
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
                                            <th>Realisasi</th>
                                            {{-- <th>Target Selesai</th> --}}
                                            {{-- <th>Status</th> --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lmlj_selesai as $item)
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
                                                {{-- <td>
                                                    <div class="urgensi rounded-circle bg-danger"></div>
                                                </td> --}}
                                                <td>
                                                    <figure class="avatar mr-2 avatar-sm bg-{{ $item->color }} text-white"
                                                        data-initial="{{ $item->target }}"></figure>
                                                </td>
                                                <td>
                                                    <figure
                                                        class="avatar mr-2 avatar-sm bg-{{ $item->color_realisasi }} text-white"
                                                        data-initial="{{ $item->created_at->diffInDays($item->updated_at) }}">
                                                    </figure>
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
