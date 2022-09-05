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
                            <h4>Kotak Keluar LMLJ</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-outbox">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Tanggal</th>
                                            <th>Nomor LMLJ</th>
                                            <th>Tujuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($masalah) > 0)
                                            @foreach ($masalah as $item)
                                                <tr id="lmlj-{{ $item->id }}">
                                                    <td class="align-middle">{{ $number++ }}</td>
                                                    <td class="align-middle">{{ $item->updated_at->format('d-M-Y') }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="badge badge-secondary text-dark">
                                                            {{ $item->nolmlj }}
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">{{ $item->unit->unit }}</td>
                                                    <td class="align-middle" id="status-{{ $item->id }}">
                                                        @if ($item->status == 10)
                                                            <div id="badge-non-aktif-{{ $item->id }}"
                                                                class="badge badge-danger text-white">
                                                                Non-Aktif
                                                            </div>
                                                        @else
                                                            <div id="badge-aktif-{{ $item->id }}"
                                                                class="badge badge-success text-white">
                                                                Active
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle" id="aksi-{{ $item->id }}">
                                                        <a href="{{ url('edit/' . $item->nolmlj) }}"
                                                            class="btn btn-primary">Edit
                                                        </a>
                                                        @if ($item->status == 10)
                                                            <a id="aktif-{{ $item->id }}" href="#"
                                                                onclick="turnonlmlj({{ $item->id }})"
                                                                class="btn btn-success">Aktifkan
                                                            </a>
                                                        @else
                                                            <a id="non-aktif-{{ $item->id }}" href="#"
                                                                onclick="deletelmlj({{ $item->id }})"
                                                                class="btn btn-danger">Delete
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
