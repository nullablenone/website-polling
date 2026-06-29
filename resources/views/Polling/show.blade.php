@extends('layouts')
@section('title', 'Pilih Jawaban Polling')
@section('content')
    <!-- Content -->
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger shadow-sm text-center">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="card border-0 rounded-lg overflow-hidden">
            <!-- Card Header -->
            <div class="card-header text-center py-4">
                <h1 class="m-0" style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.6rem; font-weight: 500; line-height: 1.2;">
                    {{ $polling->title }}
                </h1>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <p class="fs-5 text-muted mb-4">Silakan pilih salah satu jawaban di bawah untuk mengirimkan suara Anda.</p>
                    <div class="d-flex flex-column align-items-center w-100 px-md-4">
                        @php
                            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                        @endphp
                        @foreach ($polling->jawaban as $index => $jawaban)
                            <label class="luxury-option w-100 position-relative d-flex justify-content-between align-items-center mb-3">
                                <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required style="display: none;">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="option-letter-badge">{{ $letters[$index] ?? ($index + 1) }}</span>
                                    <span class="fw-bold fs-5 text-white">{{ $jawaban->option }}</span>
                                </div>
                                <i class="far fa-circle text-muted fs-4"></i>
                                <input type="hidden" value="{{ $polling->id }}" name="polling_id">
                            </label>
                        @endforeach
                    </div>
                </form>

                <!-- Actions -->
                <div class="d-flex flex-wrap justify-content-center mt-4 gap-2">
                    <a class="btn btn-primary px-4 py-3 d-flex align-items-center gap-2"
                        href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fa-solid fa-chart-pie"></i> Lihat Hasil Polling
                    </a>
                    <a class="btn btn-outline-secondary px-4 py-3 d-flex align-items-center gap-2"
                        href="{{ route('polling.pollingTerbaru') }}">
                        <i class="fa fa-check-circle"></i> Polling Terbaru
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle px-4 py-3 d-flex align-items-center gap-2" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-share-alt"></i> Bagikan
                        </button>
                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-0">
                            <li>
                                <a id="whatsappShare" class="dropdown-item py-2 d-flex align-items-center" href="#" target="_blank">
                                    <i class="fab fa-whatsapp me-2 text-success fs-5"></i> Share ke WhatsApp
                                </a>
                            </li>
                            <li>
                                <a id="telegramShare" class="dropdown-item py-2 d-flex align-items-center" href="#" target="_blank">
                                    <i class="fab fa-telegram-plane me-2 text-primary fs-5"></i> Share ke Telegram
                                </a>
                            </li>
                            <li>
                                <a id="facebookShare" class="dropdown-item py-2 d-flex align-items-center" href="#" target="_blank">
                                    <i class="fab fa-facebook-f me-2 text-info fs-5"></i> Share ke Facebook
                                </a>
                            </li>
                            <li>
                                <a id="twitterShare" class="dropdown-item py-2 d-flex align-items-center" href="#" target="_blank">
                                    <i class="fab fa-twitter me-2 text-white fs-5"></i> Share ke X (Twitter)
                                </a>
                            </li>
                        </ul>
                    </div>
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

        <!-- Create Poll Button -->
        <div class="text-center mt-4 mb-2">
            <a href="{{ route('polling.create') }}" class="btn btn-primary px-4 py-3">
                <i class="fas fa-plus me-2"></i> Buat Polling Baru
            </a>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Submit form automatically on choosing option
            document.querySelectorAll('input[name="jawaban_id"]').forEach(radioButton => {
                radioButton.addEventListener('change', function() {
                    const label = this.closest('.luxury-option');
                    if (label) {
                        document.querySelectorAll('.luxury-option').forEach(l => l.classList.remove('selected'));
                        label.classList.add('selected');
                    }
                    setTimeout(() => {
                        document.getElementById('formVote').submit();
                    }, 200); 
                });
            });

            // ------------------------ fungsi share -----------------------------
            const text = `Ayo ikuti Polling ini!\n\n"${{ $polling->title }}"\n\nHasil sementara:\n@foreach ($polling->jawaban as $jawaban)- {{ $jawaban->option }}: {{ $jawaban->vote }} suara\n@endforeach\nTotal suara yang sudah masuk: {{ $polling->jawaban->sum('vote') }}\n\nJangan sampai ketinggalan, berikan suaramu sekarang!\nKlik link berikut untuk ikut serta:`;
            
            const currentUrl = window.location.origin + `/{{ $polling->id }}`;

            // ------------------ fungsi share WhatsApp
            const whatsappShare = document.getElementById('whatsappShare');
            whatsappShare.href = `https://api.whatsapp.com/send?text=${encodeURIComponent(text + '\n' + currentUrl)}`;

            // ------------------ fungsi share telegram
            const telegramShare = document.getElementById('telegramShare');
            telegramShare.href = `https://t.me/share/url?url=${encodeURIComponent(currentUrl)}&text=${encodeURIComponent(text)}`;

            // ------------------ fungsi share facebookShare
            const facebookShare = document.getElementById('facebookShare');
            facebookShare.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}&quote=${encodeURIComponent(text)}`;

            // ------------------ fungsi share twiter
            const twitterShare = document.getElementById('twitterShare');
            twitterShare.href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(currentUrl)}`;
        });
    </script>
@endsection
