@extends('layouts')
@section('title', 'Polling Terbaru')
@section('content')
    <div class="container mt-5">

        <!-- Section Title -->
        <div class="section-title text-center mb-5 p-4 bg-gradient text-white rounded shadow">
            <h1 class="fw-bold">Polling Terbaru</h1>
        </div>

        <!-- Tambahkan Form Pencarian di sini -->
        <div class="search-bar mb-4">
            <form action="{{ route('polling.pollingTerbaru') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" autocomplete="off" placeholder="Cari polling..."
                        aria-label="Search Polling" aria-describedby="button-search">
                    <button class="btn btn-success" type="submit" id="button-search">Cari</button>
                </div>
            </form>
        </div>

        <hr>

        <!-- Cek apakah ada hasil polling -->
        @if ($kondisi && $query)
            <p>Polling dengan judul "<strong>{{ $query }}</strong>" tidak ditemukan.</p>
        @elseif ($kondisi)
            <p>Belum ada polling yang tersedia.</p>
        @else
            <!-- Daftar Polling -->
            @foreach ($pollings as $polling)
                <div class="card mb-4 polling-item shadow-lg border-0 rounded">
                    <div
                        class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-4">
                        <div class="mb-3 mb-md-0">
                            <a href="{{ route('polling.show', $polling->id) }}"
                                class="h4 text-success fw-bold">{{ $polling->title }}</a>
                            <div class="text-muted">Dibuat pada {{ $polling->created_at->format('d m Y') }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

@endsection
