@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <!-- Grid utama (Video + Rekomendasi) -->
        <div class="row">
            <!-- Kolom utama (Video & Deskripsi) -->
            <div class="col-lg-8">
                <!-- Tombol Kembali -->
                <a href="{{ route('siswa.material.list', ['subject_id' => $material->subject_id]) }}"
                    class="btn btn-secondary mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Materi
                </a>

                <!-- Judul Materi -->
                <h2 class="mb-3">{{ $material->title }}</h2>

                <!-- Media (Video/Gambar/PDF) -->
                @if (!empty($material->file_paths))
                    @foreach ($material->file_paths as $filePath)
                        @php
                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                            <img src="{{ Storage::url($filePath) }}" alt="{{ $material->title }}"
                                class="img-fluid rounded mb-3">
                        @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                            <div class="ratio ratio-16x9 mb-3">
                                <video controls class="w-100">
                                    <source src="{{ Storage::url($filePath) }}" type="video/{{ $extension }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif ($extension == 'pdf')
                            <iframe src="{{ Storage::url($filePath) }}" width="100%" height="500px"
                                class="mb-3"></iframe>
                        @endif
                    @endforeach
                @else
                    <p class="text-muted">Tidak ada file materi yang tersedia.</p>
                @endif

                <!-- Deskripsi -->
                <div class="mb-4">
                    <h5>Deskripsi:</h5>
                    @php
                        $deskripsiPenuh = $material->description ?? 'Tidak ada deskripsi yang tersedia.';
                        $deskripsiPendek = implode(' ', array_slice(explode(' ', strip_tags($deskripsiPenuh)), 0, 10));
                    @endphp

                    <p class="text-muted" id="deskripsi-{{ $material->id }}">
                        {!! nl2br(e($deskripsiPendek)) !!}...
                        @if (str_word_count($deskripsiPenuh) > 10)
                            <a href="javascript:void(0);" onclick="tampilkanDeskripsi({{ $material->id }})"
                                class="text-primary" id="lihat-selengkapnya-{{ $material->id }}">
                                Lihat Selengkapnya
                            </a>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Sidebar Rekomendasi (Seperti YouTube) -->
            <div class="col-lg-4">
                <h4 class="mb-3">Materi Rekomendasi</h4>

                @if ($recommendedMaterials->isEmpty())
                    <p class="text-muted">Belum ada rekomendasi materi.</p>
                @else
                    @foreach ($recommendedMaterials as $recMaterial)
                        <div class="d-flex mb-3 border-bottom pb-2">
                            @if (!empty($recMaterial->file_paths))
                                @foreach ($recMaterial->file_paths as $filePath)
                                    @php
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($filePath) }}" alt="{{ $recMaterial->title }}"
                                            class="img-fluid rounded"
                                            style="width: 120px; height: 80px; object-fit: cover;">
                                    @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                                        <div class="ratio ratio-16x9" style="width: 120px; height: 80px;">
                                            <video class="w-100">
                                                <source src="{{ Storage::url($filePath) }}"
                                                    type="video/{{ $extension }}">
                                            </video>
                                        </div>
                                    @endif
                                @break
                            @endforeach
                        @endif

                        <a href="{{ route('siswa.material.detail', $recMaterial->id) }}">
                            <div class="ms-3">
                                <h6>
                                    <div class="text-decoration-none text-dark">
                                        {{ Str::limit($recMaterial->title, 50, '...') }}
                                        <p class="text-muted small">
                                            {{ Str::limit($recMaterial->description, 80, '...') }}
                                        </p>
                                    </div>
                                </h6>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function tampilkanDeskripsi(id) {
        const fullDescription = `{!! nl2br(e($material->description)) !!}`;
        document.getElementById(`deskripsi-${id}`).innerHTML = fullDescription;
    }
</script>
@endpush
