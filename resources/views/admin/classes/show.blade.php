@extends('admin.layouts.app')

@section('title', 'Detail Kelas')

@push('styles')
    <style>
        /* Custom Card Styling */
        .card-custom {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .card-custom .card-header {
            background-color: #f8f9fc;
            color: #333;
            font-weight: bold;
        }

        /* Table Styling */
        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .table-custom thead th {
            background-color: #f8f9fc;
            color: #333;
            font-weight: bold;
        }

        .table-custom tbody tr:hover {
            background-color: #f1f5f9;
            transition: background-color 0.3s ease-in-out;
        }

        /* Button Styling */
        .btn-action {
            padding: 8px 12px;
            font-size: 14px;
            transition: transform 0.3s ease-in-out;
        }

        .btn-action:hover {
            transform: scale(1.05);
        }

        /* Alert Styling */
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
            border-radius: 10px;
        }

        /* Modal Styling */
        .modal-header.bg-danger {
            background-color: #e74a3b !important;
            color: white;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .card-custom .card-title {
                font-size: 1rem;
            }

            .table-custom thead th {
                font-size: 12px;
            }

            .table-custom tbody td {
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-3 mt-md-5">
        <!-- Header -->
        <!-- Page Header -->

        <h1 class="text-center mb-4 text-primary fw-bold">Detail Kelas {{ $class->name }}</h1>

        <!-- Kelas Info -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="card card-custom mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $class->name }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $class->deskripsi }}</p>
                <p class="text-muted">Jumlah Siswa: {{ $class->siswa->count() }} Siswa</p>
            </div>
        </div>

        <!-- Daftar Siswa yang tergabung dalam kelas -->
        <h4 class="mb-3">Daftar Siswa</h4>
        @if ($class->siswa->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                Tidak ada siswa yang tergabung dalam kelas ini.
            </div>
        @else
            <div class="card table-custom">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" id="students-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Siswa</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($class->siswa as $student)
                                    <tr id="student-{{ $student->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-outline-danger btn-sm btn-action remove-student"
                                                data-id="{{ $student->id }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Menambahkan Siswa -->
        <div class="mt-4">
            <h5 class="mb-3">Tambah Siswa ke Kelas</h5>
            <form action="{{ route('admin.classes.addStudentToClass', $class->id) }}" method="POST" id="add-student-form">
                @csrf
                @if ($siswaBelumMasuk->isNotEmpty())
                    <div class="form-group mb-3">
                        <label for="user_id" class="form-label">Pilih Siswa</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach ($siswaBelumMasuk as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->name }} - {{ $siswa->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-action">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Siswa
                    </button>
                @else
                    <div class="alert alert-warning">Semua siswa sudah tergabung dalam kelas.</div>
                @endif
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tambah Siswa
            $('#add-student-form').submit(function(e) {
                e.preventDefault();
                var user_id = $('#user_id').val();
                var class_id = "{{ $class->id }}";
                var url = "{{ route('admin.classes.addStudentToClass', ':id') }}".replace(':id', class_id);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: user_id
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#students-table tbody').append(`
                            <tr id="student-${response.student.id}">
                                <td>#</td>
                                <td>${response.student.name}</td>
                                <td>${response.student.email}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-danger btn-sm btn-action remove-student" data-id="${response.student.id}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                            $('#user_id option[value="' + user_id + '"]')
                                .remove(); // Hapus dari dropdown
                            if ($('#user_id option').length === 0) {
                                $('#add-student-form').html(
                                    '<div class="alert alert-warning">Semua siswa sudah tergabung dalam kelas.</div>'
                                );
                            }
                        }
                    }
                });
            });

            // Hapus Siswa
            $(document).on('click', '.remove-student', function() {
                var student_id = $(this).data('id');
                var class_id = "{{ $class->id }}";
                var url = "{{ route('admin.classes.removeStudentFromClass', ':id') }}".replace(':id',
                    class_id);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: student_id
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#student-' + response.student_id).remove();
                            // Reload siswa yang belum masuk ke dropdown
                            $('#user_id').append(
                                `<option value="${response.student_id}">${response.student_name}</option>`
                            );
                        }
                    }
                });
            });
        });
    </script>
@endpush
