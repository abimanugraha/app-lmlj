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
                        <div class="card-icon shadow-success bg-success">
                            <h2 class="mt-1 text-white">A</h2>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Performa</h4>
                            </div>
                            <div class="card-body mt-2">
                                <h5 class="text-success">Sangat Baik</h5>
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
                                        id="orders-month">July</a>
                                    <ul class="dropdown-menu dropdown-menu-sm">
                                        <li class="dropdown-title">Select Month</li>
                                        <li><a href="#" class="dropdown-item">January</a></li>
                                        <li><a href="#" class="dropdown-item">February</a></li>
                                        <li><a href="#" class="dropdown-item">March</a></li>
                                        <li><a href="#" class="dropdown-item">April</a></li>
                                        <li><a href="#" class="dropdown-item">May</a></li>
                                        <li><a href="#" class="dropdown-item">June</a></li>
                                        <li><a href="#" class="dropdown-item active">July</a></li>
                                        <li><a href="#" class="dropdown-item">August</a></li>
                                        <li><a href="#" class="dropdown-item">September</a></li>
                                        <li><a href="#" class="dropdown-item">October</a></li>
                                        <li><a href="#" class="dropdown-item">November</a></li>
                                        <li><a href="#" class="dropdown-item">December</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-stats-items mb-4 mt-3">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $total['pengajuan'] }}</div>
                                    <div class="card-stats-item-label">Pengajuan</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $total['completed'] }}</div>
                                    <div class="card-stats-item-label">Completed</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $total['tembusan'] }}</div>
                                    <div class="card-stats-item-label">Tembusan</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $total['total'] }}</div>
                                    <div class="card-stats-item-label">Total</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $total['respon_time'] }}</div>
                                    <div class="card-stats-item-label">Respon Time</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $total['finish'] }}</div>
                                    <div class="card-stats-item-label">Finish</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body"></div>
                        {{-- <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total LMLJ</h4>
                            </div>
                            <div class="card-body">
                                59
                            </div>
                        </div> --}}
                    </div>
                </div>

                {{-- <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <canvas id="sales-chart" height="80"></canvas>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Sales</h4>
                            </div>
                            <div class="card-body">
                                4,732
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                            <div class="card-header-action dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Month</a>
                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <li class="dropdown-title">Select Period</li>
                                    <li><a href="#" class="dropdown-item">Today</a></li>
                                    <li><a href="#" class="dropdown-item">Week</a></li>
                                    <li><a href="#" class="dropdown-item active">Month</a></li>
                                    <li><a href="#" class="dropdown-item">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" id="top-5-scroll">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($produk as $item)
                                    <li class="media">
                                        <img class="mr-3 rounded" width="55" src="#" alt="Produk">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div class="font-weight-600 text-muted text-small">{{ $item->total_lmlj }}
                                                    LMLJ</div>
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
