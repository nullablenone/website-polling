@extends('layouts')

@section('content')
    <!-- Content -->
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header text-center text-white">
                <h1 class="">{{ $polling->title }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <p class="fs-6 fw-bold">Klik tombol pilihan anda</p>
                    <div class="btn-group btn-group-toggle d-flex justify-content-center flex-wrap" data-toggle="buttons">
                        @foreach ($polling->jawaban as $jawaban)
                            <label class="btn btn-outline-success mb-2 rounded-2 mx-1 py-2">
                                <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required>
                                <span class="fw-bold fs-5">{{ $jawaban->option }}</span>
                                <input type="hidden" value="{{ $polling->id }}" name="polling_id">
                            </label>
                        @endforeach
                    </div>
                </form>
                <div class="dropdown mt-4 d-flex justify-content-center">
                    <a class="btn btn-primary mx-2" href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fa mr-2 fa-pie-chart text-light" aria-hidden="true"></i> Lihat Hasil Polling
                    </a>
                    <a class="btn btn-success mx-2" href="{{ route('polling.pollingTersimpan') }}">
                        <i class="fa mr-2 fa-check-circle text-light" aria-hidden="true"></i> Polling Tersimpan
                    </a>
                </div>
                <div class="col-sm-12 mt-3">
                    <div id="alert"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Ambil semua radio button dengan name="jawaban_id"
        const radioButtons = document.querySelectorAll('input[name="jawaban_id"]');

        // Tambahkan event listener untuk setiap radio button
        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', function() {
                // Submit form secara otomatis ketika radio button dipilih
                document.getElementById('formVote').submit();
            });
        });
    </script>
@endsection
