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
            <div class="section-body">
                <h2 class="section-title">Hi, {{ auth()->user()->nama }} </h2>
                <p class="section-lead">
                    Ubah informasi akun anda di halaman ini.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="{{ asset('upload_media/user/' . auth()->user()->picture) }}"
                                    class="rounded-circle
                                    profile-widget-picture">
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-value">{{ auth()->user()->nama }}</div>
                                        <div class="profile-widget-item-label">Unit {{ auth()->user()->unit->unit }}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name text-primary">Edit Profile <div
                                        class="text-muted d-inline font-weight-normal">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <form action="{{ url('edit-profile') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ auth()->user()->nama }}" name="nama">
                                            @error('nama')
                                                <div class="invalid-feedback mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                value="{{ auth()->user()->username }}" name="username">
                                            @error('username')
                                                <div class="invalid-feedback mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Password Baru</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" value=""
                                                name="password">
                                            @error('password')
                                                <div class="invalid-feedback mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="input-foto-video">Foto Profile</label>
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="custom-file-input @error('picture') is-invalid @enderror"
                                                    name="picture" id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose
                                                    file</label>
                                                @error('picture')
                                                    <div class="invalid-feedback mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="text" name="id" value="{{ auth()->user()->id }}" hidden>
                                    </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    </section>
    </div>
    </div>
@endsection
