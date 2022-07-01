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
                                        @if (count(auth()->user()->unit->masalah) > 0)
                                            @foreach (auth()->user()->unit->masalah as $item)
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
