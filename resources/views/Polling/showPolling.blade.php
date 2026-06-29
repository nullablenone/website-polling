@extends('layouts')
@section('title', 'Hasil Jajak Pendapat')
@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8">
            <!-- Editorial Heading -->
            <h1 class="text-center mb-5" style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.6rem; font-weight: 500; line-height: 1.2;">
                Hasil Polling &mdash; {{ $polling->title }}
            </h1>

            <div class="card border-0 mb-4">
                <div class="card-body p-4">
                    @php
                        // Menghitung total suara dari semua jawaban
                        $totalVotes = $polling->jawaban->sum('vote');
                    @endphp

                    <div class="d-flex flex-column gap-4 py-2">
                        @foreach ($polling->jawaban as $jawaban)
                            @php
                                // Menghitung persentase suara untuk setiap jawaban
                                $percentage = $totalVotes > 0 ? ($jawaban->vote / $totalVotes) * 100 : 0;
                            @endphp
                            <div>
                                <!-- Label & Stats -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fs-5 fw-bold text-white">{{ $jawaban->option }}</span>
                                    <span class="text-white-50 fs-6">
                                        <strong>{{ number_format($percentage, 1) }}%</strong>
                                        <span class="text-muted ms-2" style="font-size: 0.85rem;">({{ $jawaban->vote }} suara)</span>
                                    </span>
                                </div>
                                <!-- Flat Minimal Line Indicator -->
                                <div class="editorial-progress-container" style="height: 6px; background-color: #27272a; border-radius: 3px; overflow: hidden; width: 100%;">
                                    <div style="width: {{ $percentage }}%; height: 100%; background-color: #10b981; transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer text-center">
                    <h5 class="m-0 text-white-50" style="font-size: 0.95rem;">Total partisipasi: <span id="spanCount" class="text-white fw-bold">{{ $totalVotes }}</span> suara</h5>
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

            <div class="text-center mt-4 gap-3 d-flex justify-content-center">
                <a href="{{ route('polling.show', $polling->id) }}" class="btn btn-outline-secondary px-4 py-3 d-flex align-items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Polling
                </a>
                <a href="{{ route('polling.create') }}" class="btn btn-primary px-4 py-3 shadow-sm d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i> Buat Polling Baru
                </a>
            </div>
        </div>
    </div>
@endsection
