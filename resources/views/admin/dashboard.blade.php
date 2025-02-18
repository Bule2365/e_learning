@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container mt-4">
        <h1 class="display-4">Dashboard Admin</h1>
        <p class="lead text-muted">Ringkasan data sistem</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Jumlah Siswa</h5>
                        <h1 class="display-4">{{ $jumlahSiswa }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Jumlah Guru</h5>
                        <h1 class="display-4">{{ $jumlahGuru }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Jumlah Mata Pelajaran</h5>
                        <h1 class="display-4">{{ $jumlahMapel }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
