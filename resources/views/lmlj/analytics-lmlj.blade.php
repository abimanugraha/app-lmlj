@extends('layout/main')

@section('content')
    <!-- Main Content -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="main-content">
        <section class="section">
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-body">
                                {{ $title }}
                            </div>
                        </div>
                        <div id="card-performa" class="card-icon shadow-{{ $performa->warna }} bg-{{ $performa->warna }}">
                            <h2 id="performa" class="mt-1 text-white">{{ $performa->nilai }}</h2>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Performa</h4>
                            </div>
                            <div class="card-body mt-2">
                                <h5 id="keterangan" class="text-{{ $performa->warna }}">{{ $performa->keterangan }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">LMLJ Statistics -
                                <div class="dropdown d-inline">
                                    <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#"
                                        id="orders-month">{{ date('M') }}</a>
                                    <ul class="dropdown-menu dropdown-menu-sm">
                                        <li class="dropdown-title">Select Month</li>
                                        <li><a href="#" id="m1" onclick="selectMonth(1)"
                                                class="dropdown-item">January</a>
                                        </li>
                                        <li><a href="#" id="m2" onclick="selectMonth(2)"
                                                class="dropdown-item">February</a>
                                        </li>
                                        <li><a href="#" id="m3" onclick="selectMonth(3)"
                                                class="dropdown-item">March</a></li>
                                        <li><a href="#" id="m4" onclick="selectMonth(4)"
                                                class="dropdown-item">April</a></li>
                                        <li><a href="#" id="m5" onclick="selectMonth(5)"
                                                class="dropdown-item">May</a></li>
                                        <li><a href="#" id="m6" onclick="selectMonth(6)"
                                                class="dropdown-item">June</a></li>
                                        <li><a href="#" id="m7" onclick="selectMonth(7)"
                                                class="dropdown-item">July</a>
                                        </li>
                                        <li><a href="#" id="m8" onclick="selectMonth(8)"
                                                class="dropdown-item">August</a></li>
                                        <li><a href="#" id="m9" onclick="selectMonth(9)"
                                                class="dropdown-item">September</a>
                                        </li>
                                        <li><a href="#" id="m10" onclick="selectMonth(10)"
                                                class="dropdown-item">October</a>
                                        </li>
                                        <li><a href="#" id="m11" onclick="selectMonth(11)"
                                                class="dropdown-item">November</a>
                                        </li>
                                        <li><a href="#" id="m12" onclick="selectMonth(12)"
                                                class="dropdown-item">December</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-stats-items mb-4 mt-3">
                                <div class="card-stats-item">
                                    <div id="pengajuan" class="card-stats-item-count">{{ $total['pengajuan'] }}</div>
                                    <div class="card-stats-item-label">Pengajuan</div>
                                </div>
                                <div class="card-stats-item">
                                    <div id="completed" class="card-stats-item-count">{{ $total['completed'] }}</div>
                                    <div class="card-stats-item-label">Completed</div>
                                </div>
                                <div class="card-stats-item">
                                    <div id="tembusan" class="card-stats-item-count">{{ $total['tembusan'] }}</div>
                                    <div class="card-stats-item-label">Tembusan</div>
                                </div>
                                <div class="card-stats-item">
                                    <div id="total" class="card-stats-item-count">{{ $total['total'] }}</div>
                                    <div class="card-stats-item-label">Total</div>
                                </div>
                                <div class="card-stats-item">
                                    <div id="respon-time" class="card-stats-item-count">{{ $total['respon_time'] }}</div>
                                    <div class="card-stats-item-label">Respon Time</div>
                                </div>
                                <div class="card-stats-item">
                                    <div id="finish" class="card-stats-item-count">{{ $total['finish'] }}</div>
                                    <div class="card-stats-item-label">On Target</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>LMLJ in this year</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="158"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card gradient-bottom">
                        <div class="card-header">
                            <h4>Top 5 Produk</h4>
                            {{-- <div class="card-header-action dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Month</a>
                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <li class="dropdown-title">Select Period</li>
                                    <li><a href="#" class="dropdown-item">Today</a></li>
                                    <li><a href="#" class="dropdown-item">Week</a></li>
                                    <li><a href="#" class="dropdown-item active">Month</a></li>
                                    <li><a href="#" class="dropdown-item">This Year</a></li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="card-body" id="top-5-scroll">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($produk as $item)
                                    <li class="media">
                                        <img class="mr-3 rounded" width="55" src="#" alt="Produk">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div class="badge badge-light">
                                                    {{ $item->total_lmlj }}</div>
                                                {{-- <div class="font-weight-600 text-muted text-small">{{ $item->total_lmlj }}
                                                    LMLJ</div> --}}
                                            </div>
                                            <div class="media-title">{{ $item->nama }}</div>
                                            <div class="mt-1">

                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

<script>
    function selectMonth(month) {
        $(`.dropdown-item`).attr('class', 'dropdown-item');
        var dm = $(`#m` + month).attr('class', 'dropdown-item active');
        $(`#orders-month`).text(dm.text());

        $.ajax({
            url: `{{ url('ajax/data-statistic-lmlj') }}` + `/` + month,
            success: function(res) {
                const result = Object.values(res);
                console.log(res);
                $(`#pengajuan`).text(`${res.pengajuan}`);
                $(`#completed`).text(`${res.completed}`);
                $(`#completed`).text(`${res.completed}`);
                $(`#tembusan`).text(`${res.tembusan}`);
                $(`#tembusan`).text(`${res.tembusan}`);
                $(`#total`).text(`${res.total}`);
                $(`#respon-time`).text(`${res.respon_time}`);
                $(`#finish`).text(`${res.finish}`);
                $(`#card-performa`).attr(`class`,
                    `card-icon shadow-${res.performa.warna} bg-${res.performa.warna}`);
                $(`#performa`).text(res.performa.nilai);
                $(`#keterangan`).text(res.performa.keterangan);
                $(`#keterangan`).attr('class', `text-${res.performa.warna}`);
            }
        });
    }

    function chart(date = new Date()) {
        $.ajax({
            url: `{{ url('ajax/chart-data-lmlj') }}` + `/` + date.getFullYear(),
            success: function(res) {
                const result = Object.values(res);
                generateChart(result);
                // console.log(result);
            }
        });
    }
    document.addEventListener("DOMContentLoaded", () => {
        chart();
    });
</script>
