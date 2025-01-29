@extends('guru.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Daftar Kelas Anda</h1>

    @if($classes->isEmpty())
    {{-- <div class="alert alert-info">
        <p>Belum ada kelas yang Anda masuki. Silakan hubungi admin untuk penugasan kelas.</p>
        <a href="{{ route('guru.classes.create') }}" class="btn btn-primary">Buat Kelas Baru</a>
    </div> --}}
    @else
    <div class="row">
        @foreach($classes as $class)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm rounded-3 border-light" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">{{ $class->name }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Daftar Siswa yang Bergabung:</strong></p>
                    @if($class->siswa->isEmpty())
                    <p>Belum ada siswa yang bergabung.</p>
                    @else
                    <ul>
                        @foreach($class->siswa as $siswa)
                        <li>{{ $siswa->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn {
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
@endpush