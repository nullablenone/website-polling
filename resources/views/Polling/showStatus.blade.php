@extends('layouts')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="text-success fw-bold">Terima kasih</h2>
                <p class="mb-4">Pilihan Anda berhasil disimpan!</p>
                <div>
                    <i class="fas fa-check-circle text-success" style="font-size: 150px;"></i>
                </div>
                <div class="mt-4">
                    <a class="btn btn-info mb-2" href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fas fa-pie-chart mr-2"></i> Lihat Hasil Polling
                    </a>
                    <br>
                    {{-- url()->previous() untuk mengembalikan ke halaman sebelumnya --}}
                    <a class="btn btn-dark mt-2" href="{{ url()->previous() }}"> 
                        <i class="fas fa-arrow-left mr-2"></i> Kembali Ke Polling
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div id="alert"></div>
        </div>
    </div>
@endsection
