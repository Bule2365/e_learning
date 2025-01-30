@extends('admin.layouts.app')

@section('title', 'User Index')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4 mb-3">Selamat Datang, {{ Auth::user()->name }}</h1>
            <p class="lead text-muted">Ini adalah halaman untuk mengelola pengguna. Anda dapat melihat dan mengelola daftar pengguna di sini.</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><i class="fas fa-users"></i> Manajemen Pengguna</h5>
        </div>
        <div class="card-body">
            <!-- Nanti bisa ditambahkan tabel atau daftar pengguna di sini -->
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Tambahkan konten manajemen pengguna di sini
            </div>
        </div>
    </div>
</div>
@endsection