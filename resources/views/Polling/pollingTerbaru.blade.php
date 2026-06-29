@extends('layouts')
@section('title', 'Daftar Polling Terbaru')
@section('content')
    <div class="container mt-5">

        <!-- Section Title / Card Header -->
        <div class="section-title text-center mb-5 p-4 text-white rounded">
            <h2 class="m-0 fw-bold" style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.2rem;">Daftar Polling Terbaru</h2>
        </div>

        <!-- Tambahkan Form Pencarian di sini -->
        <div class="search-bar mb-5">
            <form action="{{ route('polling.pollingTerbaru') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" autocomplete="off"
                        placeholder="Cari topik polling..." aria-label="Cari Polling" aria-describedby="button-search">
                    <button class="btn btn-primary d-flex align-items-center gap-2" type="submit" id="button-search" style="margin: 2px;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <hr style="border-color: rgba(255,255,255,0.08);">

        <!-- Cek apakah ada hasil polling -->
        @if ($kondisi && $query)
            <div class="alert alert-danger text-center p-4">
                <i class="fas fa-exclamation-triangle me-2"></i> Polling dengan topik "<strong>{{ $query }}</strong>" tidak ditemukan.
            </div>
            <div class="d-flex justify-content-center">
                <button onclick="window.history.back()" class="btn btn-outline-secondary mt-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </button>
            </div>
        @elseif ($kondisi)
            <div class="alert alert-info text-center p-4">
                <i class="fas fa-info-circle me-2"></i> Belum ada polling yang diterbitkan saat ini.
            </div>
        @else
            <!-- Daftar Polling -->
            <div class="row">
                @foreach ($pollings as $polling)
                    <div class="col-12 mb-4">
                        <div class="card polling-item border-0 shadow-sm">
                            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-4">
                                <div class="mb-3 mb-md-0">
                                    <a href="{{ route('polling.show', $polling->id) }}" class="h4 fw-bold luxury-poll-link">
                                        {{ $polling->title }}
                                    </a>
                                    <div class="text-muted mt-2 fs-6 d-flex align-items-center gap-2">
                                        <i class="far fa-calendar-alt text-white-50"></i>
                                        <span>Diterbitkan pada {{ $polling->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('polling.show', $polling->id) }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                                    Ikuti Polling <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
