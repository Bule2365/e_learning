@extends('admin.layouts.app')

@section('title', 'User Index')

@section('content')
<div>
    <h1>Selamat Datang, {{Auth::user()->name}}</h1>
    <p>Ini adalah halaman untuk mengelola pengguna. Anda dapat melihat dan mengelola daftar pengguna di sini.</p>
</div>
@endsection