@extends('admin.layouts.app')

@push('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease-in-out;
        }

        .table-primary {
            background-color: #4e73df;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Siswa yang Mengikuti {{ $exam->title }}</h2>
            <a href="{{ route('admin.exams.byClass', $exam->class_id) }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm rounded">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exam->upayaUjian as $attempt)
                        <tr>
                            <td class="fw-bold text-dark">{{ $attempt->user->name }}</td>
                            <td>{{ $attempt->started_at }}</td>
                            <td>{{ $attempt->submitted_at }}</td>
                            <td>
                                <span
                                    class="badge {{ $attempt->score >= 75 ? 'bg-success' : ($attempt->score >= 70 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $attempt->score }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
