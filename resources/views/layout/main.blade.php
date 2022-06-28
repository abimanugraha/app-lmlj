<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Aplikasi LMLJ | {{ $title }}</title>
    <link rel="icon" href="{{ url('assets/img/logo-mak-text.png') }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/components.css') }}">
</head>

<body class="sidebar-mini">

    <div id="app">
        <div class="main-wrapper">
            <!-- Navbar -->
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg @if (count(auth()->user()->unit->masalah) > 0) beep @endif"><i
                                class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    {{-- <a href="#">Mark All As Read</a> --}}
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                @if (count(auth()->user()->unit->masalah) > 0)
                                    @foreach (auth()->user()->unit->masalah as $item)
                                        <a href="#" class="dropdown-item dropdown-item-unread">
                                            <div class="dropdown-item-icon bg-{{ $item->color }} text-white">
                                                {{ $item->target }}
                                                {{-- <figure class="avatar mr-2 avatar-sm bg-danger text-white"
                                                    data-initial="{{ $item->urgensi }}"></figure>
                                                <i class="fas fa-code"></i> --}}
                                            </div>
                                            <div class="dropdown-item-desc">
                                                {{ $item->nolmlj }}
                                                <div class="time text-primary">{{ $item->pengaju->unit->unit }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                                {{-- <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-icon bg-primary text-white">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Template update is available now!
                                        <div class="time text-primary">2 Min Ago</div>
                                    </div>
                                </a> --}}
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ url('kotak-masuk-lmlj') }}">View All <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ url('assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">{{ auth()->user()->nama }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Unit {{ auth()->user()->unit->unit }}</div>
                            <a href="#" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ url('/logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt"></i>
                                    Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">Aplikasi LMLJ</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ url('dashboard') }}">LMLJ</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Menu</li>
                        <li class="{{ $slug === 'dashboard' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('dashboard') }}">
                                <i class="fas fa-rocket"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ $slug === 'pengajuan-lmlj' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pengajuan-lmlj') }}">
                                <i class="fas fa-plus-circle"></i>
                                <span>Pengajuan LMLJ</span>
                            </a>
                        </li>
                        <li class="{{ $slug === 'kotak-masuk-lmlj' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('kotak-masuk-lmlj') }}">
                                <i class="fas fa-inbox"></i>
                                <span>Kotak Masuk LMLJ</span>
                            </a>
                        </li>
                        <li class="{{ $slug === 'rekap-progress-lmlj' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('rekap-progress-lmlj') }}">
                                <i class="fas fa-book"></i>
                                <span>Rekap Progress LMLJ</span>
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            @yield('content')

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; Unit IT 2022
                </div>
                <div class="footer-right">
                    Beta
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ url('assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ url('assets/js/scripts.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    {{-- <script src="{{ url('assets/js/coco.min.js') }}"></script> --}}

</body>

</html>
