@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-file-alt"></i>
                        </div>
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
                        <div class="card-icon bg-warning">
                            <i class="fas fa-spinner"></i>
                        </div>
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
                                                <td>{{ $item->user->unit->unit }}</td>
                                                <td>{{ $item->unit->unit }}</td>
                                                {{-- <td>
                                                    <div class="urgensi rounded-circle bg-danger"></div>
                                                </td> --}}
                                                <td>
                                                    <figure class="avatar mr-2 avatar-sm bg-danger text-white"
                                                        data-initial="{{ $item->target }}"></figure>
                                                </td>
                                                <td>
                                                    <div class="badge badge-warning">On Progress</div>
                                                </td>
                                                <td><a href="{{ url('detail') }}" class="btn btn-primary">Detail</a></td>
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
