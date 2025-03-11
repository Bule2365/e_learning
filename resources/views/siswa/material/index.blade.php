@extends('siswa.layouts.app')

@push('styles')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1rem;
            padding: 0.75rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
        }

        /* Untuk memastikan kartu tetap responsif */
        .card-body {
            text-align: center;
        }

        .text-center {
            text-align: center !important;
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">Daftar Mata Pelajaran</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($subjects as $subject)
                <div class="col">
                    <div class="card shadow-lg rounded-4 hover-shadow">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $subject->name }}</h5>
                            <p class="text-muted text-center">
                                {{ $subject->material_count }} Materi tersedia
                            </p>
                            <a href="{{ route('siswa.material.list', $subject->id) }}" class="btn btn-primary w-100 mt-3">
                                Lihat Materi
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.classList.add('wow', 'fadeInUp');
                });
            });
        </script>
    @endpush
@endsection
