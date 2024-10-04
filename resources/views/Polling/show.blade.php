@extends('layouts')
@section('title', 'Pilih Polling')
@section('content')
    <!-- Content -->
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-lg">

            <div class="card-header text-center text-white">
                <h1>{{ $polling->title }}</h1>
            </div>

            <div class="card-body">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <p class="fs-5 fw-bold">Klik tombol pilihan Anda</p>
                    <div class="d-flex flex-column align-items-center">
                        @foreach ($polling->jawaban as $jawaban)
                            <label class="btn btn-outline-success mb-2 rounded-2 py-2 shadow w-100 position-relative">
                                <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required
                                    style="display: none;">
                                <span class="fw-bold fs-5">{{ $jawaban->option }}</span>
                                <input type="hidden" value="{{ $polling->id }}" name="polling_id">
                            </label>
                        @endforeach
                    </div>
                </form>

                <div class="d-flex justify-content-center mt-4">
                    <a class="btn btn-primary mx-2 shadow" href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fa fa-pie-chart mr-2 text-light" aria-hidden="true"></i> Lihat Hasil Polling
                    </a>
                    <a class="btn btn-success mx-2 shadow" href="{{ route('polling.pollingTerbaru') }}">
                        <i class="fa fa-check-circle mr-2 text-light" aria-hidden="true"></i> Polling Tersimpan
                    </a>
                </div>
            </div>
        </div>

        <div class="alert alert-info text-center mt-4 card shadow-lg">
            <h5 class="alert-heading"><strong>TENTANG POLLING INI</strong></h5>
            <p>Polling tentang <span class="fw-bold"><a href="#"
                        class="text-info text-decoration-none">{{ $polling->title }}</a></span> dibuat pada <span
                    class="fw-bold">{{ $polling->created_at->format('d-m-Y') }}</span></p>
            <p>Polling ini memiliki opsi jawaban dan sudah menerima <span class="fw-bold"
                    id="cVote">{{ $polling->jawaban->sum('vote') }}</span> suara.</p>
            <p class="mb-0">Melakukan pemilihan berulang kali tidak diperbolehkan. Pemeriksaan duplikasi didasarkan pada
                alamat IP pemilih. Kami tidak mentolerir setiap kecurangan yang dilakukan dan akan menganulir semua suara
                yang berindikasi dilakukan oleh bot.</p>
        </div>

        <div class="text-center">
            <a href="{{ route('polling.create') }}" class="btn btn-danger mt-4 shadow">Buat Polling Anda Sendiri</a>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.querySelectorAll('input[name="jawaban_id"]').forEach(radioButton => {
            radioButton.addEventListener('change', function() {
                document.getElementById('formVote').submit();
            });
        });
    </script>
@endsection
