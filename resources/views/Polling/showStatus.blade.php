@extends('layouts')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <h2 class="text-success fw-bold">Terima kasih</h2>
                <p class="mb-4">Pilihan Anda berhasil disimpan!</p>
                <div>
                    <i class="fas fa-check-circle text-success" style="font-size: 150px;"></i>
                </div>
                <div class="mt-4">
                    <a class="btn btn-info mb-2 shadow" href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fas fa-pie-chart mr-2"></i> Lihat Hasil Polling
                    </a>
                    <br>
                    {{-- url()->previous() untuk mengembalikan ke halaman sebelumnya --}}
                    <a class="btn btn-dark mt-2 shadow" href="{{ url()->previous() }}">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali Ke Polling
                    </a>
                </div>
            </div>
        </div>
        <div class="alert alert-info text-center mt-4 card shadow">
            <h5 class="alert-heading"><strong>TENTANG POLLING INI</strong></h5>
            <p>Polling tentang <span class="fw-bold"><a href="#"
                        class="text-info text-decoration-none">{{ $polling->title }}</a></span> dibuat pada <span
                    class="fw-bold">{{ $polling->created_at->format('d-m-Y') }}</span>
            </p>
            <p>Polling ini memiliki opsi jawaban dan sudah menerima <span class="fw-bold"
                    id="cVote">{{ $polling->jawaban->sum('vote') }}</span> suara.</p>
            <hr>
            <p class="mb-0">Melakukan pemilihan berulang kali tidak diperbolehkan. Pemeriksaan duplikasi didasarkan pada
                alamat IP pemilih. Kami tidak mentolerir setiap kecurangan yang dilakukan dan akan menganulir semua suara
                yang
                berindikasi dilakukan oleh bot.</p>
        </div>

        <div class="text-center">
            <a href="{{ route('polling.create') }}" class="btn btn-danger mt-4 shadow">Buat Polling Anda Sendiri</a>
        </div>

    </div>
@endsection
