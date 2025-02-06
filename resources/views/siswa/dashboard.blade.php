@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container">
    <h1>Dashboard Siswa</h1>

    @if(session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
    @endif

    @if(Auth::user()->kelas()->count() > 0)
    <p>Selamat datang, {{ Auth::user()->name }}! Anda sudah bergabung dengan kelas
        @foreach(Auth::user()->kelas as $class)
        {{ $class->name }}
        @endforeach
    </p>
    @else
    <p>Anda belum bergabung dengan kelas.</p>
    @endif
</div>
@endsection