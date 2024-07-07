@extends('layouts')

@section('content')
    <!-- Content -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="">{{ $polling->title }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <p class="fs-6 fw-bold">Klik tombol pilihan anda</p>
                    <div class="mb-2"></div>
                    <div class="btn-group btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                        @foreach ($polling->jawaban as $jawaban)
                            <label class="btn btn-primary mb-2 rounded-2 mx-1 py-2">
                                <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required>
                                <span class="fw-bold fs-5">{{ $jawaban->option }}</span>
                            </label>
                        @endforeach
                    </div>
                    <input type="hidden" name="polling_id" value="{{ $polling->id }}">
                    <!-- Hapus tombol Vote -->
                </form>
                <div class="col-sm-12">
                    <div id="alert"></div>
                </div>
            </div>
        </div>
    </div>

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
