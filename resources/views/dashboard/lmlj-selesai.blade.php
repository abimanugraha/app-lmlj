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
                                            {{-- <th>Target Selesai</th> --}}
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{ $lmlj_proses[0]->target }} --}}
                                        {{-- {{ die() }} --}}
                                        {{-- {{ dd($lmlj_proses[0]) }} --}}
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
                                                {{-- <td>
                                                    <div class="urgensi rounded-circle bg-danger"></div>
                                                </td> --}}
                                                <td>
                                                    <figure class="avatar mr-2 avatar-sm bg-{{ $item->color }} text-white"
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
                                        {{-- <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>2022-06-01</td>
                                            <td class="align-middle">
                                                <div class="badge badge-secondary text-dark">
                                                    UNIT-LMLJ/06/22/001
                                                </div>
                                            </td>
                                            <td>Unit Pengaju</td>
                                            <td>Unit Tujuan</td>
                                            <td>
                                                <div class="urgensi rounded-circle bg-danger"></div>
                                            </td>
                                            <td>3 Hari</td>
                                            <td>
                                                <div class="badge badge-success">Completed</div>
                                            </td>
                                            <td><a href="{{ url('detail') }}" class="btn btn-primary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                2
                                            </td>
                                            <td>2022-06-01</td>
                                            <td class="align-middle">
                                                <div class="badge badge-secondary text-dark">
                                                    UNIT-LMLJ/06/22/001
                                                </div>
                                            </td>
                                            <td>Unit Pengaju</td>
                                            <td>Unit Tujuan</td>
                                            <td>
                                                <div class="urgensi rounded-circle bg-warning"></div>
                                            </td>
                                            <td>7 Hari</td>
                                            <td>
                                                <div class="badge badge-warning">On Progress</div>
                                            </td>
                                            <td><a href="{{ url('detail') }}" class="btn btn-primary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                3
                                            </td>
                                            <td>2022-06-01</td>
                                            <td class="align-middle">
                                                <div class="badge badge-secondary text-dark">
                                                    UNIT-LMLJ/06/22/001
                                                </div>
                                            </td>
                                            <td>Unit Pengaju</td>
                                            <td>Unit Tujuan</td>
                                            <td>
                                                <div class="urgensi rounded-circle bg-success"></div>
                                            </td>
                                            <td>14 Hari</td>
                                            <td>
                                                <div class="badge badge-danger">Diteruskan</div>
                                            </td>
                                            <td><a href="{{ url('detail') }}" class="btn btn-primary">Detail</a></td>
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
