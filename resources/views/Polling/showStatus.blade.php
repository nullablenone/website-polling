@extends('layouts')
@section('title', 'Status Pengiriman')
@section('content')
    <div class="container mt-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body text-center p-5">
                <h2 class="fw-bold mb-2" style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.5rem; color: #ffffff;">
                    Terima Kasih
                </h2>
                <p class="mb-4 text-white-50 fs-5">Pilihan suara Anda berhasil disimpan ke dalam sistem.</p>
                
                <div class="mb-5 d-flex justify-content-center">
                    <div class="success-icon-wrapper">
                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 100px;"></i>
                    </div>
                </div>
                
                <div class="d-flex flex-column align-items-center gap-3">
                    <a class="btn btn-info shadow-sm px-5 py-3 w-100 d-flex align-items-center justify-content-center gap-2" href="{{ route('polling.showPolling', $polling->id) }}" style="max-width: 300px;">
                        <i class="fas fa-chart-pie"></i> Lihat Hasil Polling
                    </a>
                    <a class="btn btn-dark shadow-sm px-5 py-3 w-100 d-flex align-items-center justify-content-center gap-2" href="{{ route('polling.show', $polling->id) }}" style="max-width: 300px;">
                        <i class="fas fa-arrow-left"></i> Kembali Ke Polling
                    </a>
                </div>
            </div>
        </div>

        <!-- Polling Info -->
        <div class="alert alert-info text-center mt-4 card border-0 p-4">
            <h5 class="alert-heading fw-bold mb-3" style="font-family: 'Playfair Display', Georgia, serif; color: #ffffff; font-size: 1.25rem;">
                Informasi Polling
            </h5>
            <p class="mb-2">Polling bertajuk "<strong><span class="text-white">{{ $polling->title }}</span></strong>" diterbitkan pada tanggal
                <strong>{{ $polling->created_at->format('d-m-Y') }}</strong>.
            </p>
            <p class="mb-2">Hingga saat ini, polling telah menerima <strong>{{ $polling->jawaban->sum('vote') }}</strong> suara.</p>
            <p class="mb-0 text-muted" style="font-size: 0.9rem;">Untuk menjaga validitas, sistem membatasi voting berulang berdasarkan alamat IP pemilih.</p>
        </div>
        
        <div class="text-center mt-4 mb-2">
            <a href="{{ route('polling.create') }}" class="btn btn-primary px-4 py-3">
                <i class="fas fa-plus me-2"></i> Buat Polling Baru
            </a>
        </div>
    </div>
@endsection
