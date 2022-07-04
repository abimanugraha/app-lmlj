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
                    <div class="card">
                        <div class="card-header">
                            <h4>Rekap Progress LMLJ</h4>
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
                                            <th>Masalah</th>
                                            <th>Foto</th>
                                            <th>Pengirim</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jawaban as $item)
                                            <tr>
                                                <td>{{ $number++ }}</td>
                                                <td>{{ $item->masalah->created_at->format('d-M-Y') }}</td>
                                                <td class="align-middle">
                                                    <div class="badge badge-secondary text-dark">
                                                        {{ $item->masalah->nolmlj }}
                                                    </div>
                                                </td>
                                                <td>{{ $item->masalah->masalah }}</td>
                                                <td>
                                                    <img src="assets/img/warning.png" alt="masalah" width="50">
                                                </td>
                                                <td>{{ $item->masalah->pengaju->unit->unit }}</td>
                                                <td><a href="{{ url('lembar-rekap-progress/' . $item->masalah->nolmlj . '/' . $item->id) }}"
                                                        class="btn btn-warning">Rekap</a></td>
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
