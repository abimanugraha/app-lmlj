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
                                                <td class="align-middle">{{ $number++ }}</td>
                                                <td class="align-middle">{{ $item->masalah->created_at->format('d-M-Y') }}
                                                </td>
                                                <td class="align-middle">
                                                    <div class="badge badge-secondary text-dark">
                                                        {{ $item->masalah->nolmlj }}
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ $item->masalah->masalah }}</td>
                                                <td class="align-middle">
                                                    @if ($item->masalah->media->count() > 0)
                                                        <div class="gallery gallery-sm">
                                                            <div style="border: 2px solid #cdd3d8;" class="gallery-item"
                                                                data-image="{{ asset('upload_media/masalah/' . $item->masalah->lmlj->pengaju->unit->unit . '/' . $item->masalah->media[0]->file) }}"
                                                                data-title="Foto Masalah"></div>
                                                        </div>
                                                    @else
                                                        <img src="assets/img/warning.png" alt="masalah" width="50">
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $item->masalah->lmlj->pengaju->unit->unit }}
                                                </td>
                                                <td class="align-middle"><a
                                                        href="{{ url('lembar-rekap-progress/' . $item->masalah->nolmlj . '/' . $item->id) }}"
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
