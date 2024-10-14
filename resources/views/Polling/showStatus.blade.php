@extends('layouts')
@section('title', 'Status')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <h2 class="text-success fw-bold">Terima kasih</h2>
                <p class="mb-4">Pilihan Anda berhasil disimpan!</p>
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 150px;"></i>
                </div>
                <div>
                    <a class="btn btn-info mb-2 shadow" href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fas fa-pie-chart mr-2"></i> Lihat Hasil Polling
                    </a>
                    <br>
                    <a class="btn btn-dark mt-2 shadow" href="{{ url()->previous() }}">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali Ke Polling
                    </a>
                </div>
            </div>
        </div>

        <!-- Polling Info -->
        <div class="alert alert-info text-center mt-4 card shadow-sm border-0 rounded-lg">
            <h5 class="alert-heading"><strong>TENTANG POLLING INI</strong></h5>
            <p>Polling tentang <strong><a href="#" class="text-success">{{ $polling->title }}</a></strong> dibuat pada
                <strong>{{ $polling->created_at->format('d-m-Y') }}</strong>.
            </p>
            <p>Polling ini memiliki opsi jawaban dan sudah menerima <strong>{{ $polling->jawaban->sum('vote') }}</strong>
                suara.</p>
            <p>Melakukan pemilihan berulang kali tidak diperbolehkan. Pemeriksaan duplikasi didasarkan pada alamat IP
                pemilih.</p>
        </div>
        <div class="text-center">
            <a href="{{ route('polling.create') }}" class="btn mt-4 shadow"
                style="background-color: #00BFFF; color: white;">
                <i class="fas fa-plus"></i> Buat Polling
            </a>
        </div>
    </div>
@endsection
