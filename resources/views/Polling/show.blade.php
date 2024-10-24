@extends('layouts')
@section('title', 'Pilih Polling')
@section('content')
    <!-- Content -->
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger shadow-sm rounded-pill text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
            <!-- Card Header -->
            <div class="card-header text-center text-white">
                <h2 class="fw-bold">{{ $polling->title }}</h2>
            </div>

            <!-- Card Body -->
            <div class="card-body" style="background-color: #ffffff;">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <p class="fs-5 text-muted mb-4">Klik pilihan Anda untuk memberikan suara</p>
                    <div class="d-flex flex-column align-items-center">

                        @if ($polling->is_foto != true)
                            @foreach ($polling->jawaban as $jawaban)
                                <label
                                    class="btn btn-outline-success mb-3 rounded-pill py-2 px-4 shadow-sm w-100 position-relative"
                                    style="transition: background-color 0.3s;">

                                    <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required
                                        style="display: none;">
                                    <span class="fw-bold fs-5">{{ $jawaban->option }}</span>

                                    <input type="hidden" value="{{ $polling->id }}" name="polling_id">
                                </label>
                            @endforeach
                        @else
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 justify-content-center">
                                @foreach ($polling->jawaban as $jawaban)
                                    <div class="col my-5">
                                        <label class="btn position-relative w-100 p-0"
                                            style="transition: background-color 0.3s; cursor: pointer;">
                                            <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required
                                                style="display: none;">

                                            <!-- Foto Pilihan -->
                                            <img src="{{ asset($jawaban->option) }}" alt="Pilihan Foto"
                                                class="img-fluid shadow-sm polling-option shadow-lg"
                                                style="width: 100%; height: 300px; object-fit: cover; border-radius: 10px; transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;">

                                            <input type="hidden" value="{{ $polling->id }}" name="polling_id">
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </form>

                <!-- Actions -->
                <div class="d-flex justify-content-center mt-4 gap-2">
                    <a class="btn btn-primary shadow-sm rounded-pill px-4 py-2"
                        href="{{ route('polling.showPolling', $polling->id) }}">
                        <i class="fa fa-pie-chart me-2"></i> Lihat Hasil Polling
                    </a>
                    <a class="btn btn-success shadow-sm rounded-pill px-4 py-2"
                        href="{{ route('polling.pollingTerbaru') }}">
                        <i class="fa fa-check-circle me-2"></i> Polling Terbaru
                    </a>
                    <button class="btn btn-secondary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" type="button"
                        data-bs-toggle="dropdown">
                        <i class="fa fa-share-alt me-2"></i> Bagikan
                    </button>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu">
                        <li>
                            <a id="whatsappShare" class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fab fa-whatsapp me-2 text-success"></i> Share via WhatsApp
                            </a>
                        </li>
                        <li>
                            <a id="telegramShare" class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fab fa-telegram-plane me-2 text-primary"></i> Share via Telegram
                            </a>
                        </li>
                        <li>
                            <a id="facebookShare" class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fab fa-facebook-f me-2 text-info"></i> Share via Facebook
                            </a>
                        </li>
                        <li>
                            <a id="twitterShare" class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fab fa-twitter me-2 text-info"></i> Share via X (Twitter)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Polling Info -->
        <div class="alert alert-info text-center mt-4 card shadow-sm border-0 rounded-lg">
            <h5 class="alert-heading"><strong>TENTANG POLLING INI</strong></h5>
            <p>Polling tentang <strong><a href="#" class="text-success">{{ $polling->title }}</a></strong> dibuat
                pada
                <strong>{{ $polling->created_at->format('d-m-Y') }}</strong>.
            </p>
            <p>Polling ini memiliki opsi jawaban dan sudah menerima <strong>{{ $polling->jawaban->sum('vote') }}</strong>
                suara.</p>
            <p>Melakukan pemilihan berulang kali tidak diperbolehkan. Pemeriksaan duplikasi didasarkan pada alamat IP
                pemilih.</p>
        </div>

        <!-- Create Poll Button -->
        <div class="text-center">
            <a href="{{ route('polling.create') }}" class="btn mt-4 shadow"
                style="background-color: #00BFFF; color: white;">
                <i class="fas fa-plus"></i> Buat Polling
            </a>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.querySelectorAll('input[name="jawaban_id"]').forEach(radioButton => {
            radioButton.addEventListener('change', function() {
                document.getElementById('formVote').submit();
            });
        });

        // ------------------------ fungsi share -----------------------------


        const text = `
        Ayo ikuti Polling ini!

        {{ $polling->title }}

        Hasil sementara:
        @foreach ($polling->jawaban as $jawaban)
        - {{ $jawaban->option }}: {{ $jawaban->vote }}%
        @endforeach

        Total suara yang sudah masuk: {{ $polling->jawaban->sum('vote') }}

        Jangan sampai ketinggalan, berikan suaramu sekarang!
        Klik link berikut untuk ikut serta: http://website-polling.test/polling/{{ $polling->id }}
        `.trim();



        // ------------------ fungsi share WhatsApp
        const whatsappShare = document.getElementById('whatsappShare');
        whatsappShare.href =
            `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}%0Ahttp://website-polling.test:8080/{{ $polling->id }}`;


        // ------------------ fungsi share telegram
        const telegramShare = document.getElementById('telegramShare');
        telegramShare.href =
            `https://t.me/share/url?url=${encodeURIComponent('http://website-polling.test:8080/{{ $polling->id }}')}&text=${encodeURIComponent(text)}`;


        // ------------------ fungsi share facebookShare
        const facebookShare = document.getElementById('facebookShare');
        facebookShare.href =
            `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('http://website-polling.test:8080/{{ $polling->id }}')}&quote=${encodeURIComponent(text)}`;


        // ------------------ fungsi share twiter
        const twitterShare = document.getElementById('twitterShare');
        twitterShare.href =
            `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent('http://website-polling.test:8080/{{ $polling->id }}')}`;


        document.querySelectorAll('.polling-option').forEach(option => {
            option.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';
            });

            option.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
            });

            option.addEventListener('click', function() {
                document.querySelectorAll('.polling-option').forEach(el => {
                    el.style.border = 'none';
                });
                this.style.border = '3px solid #00BFFF'; // Menambahkan border saat dipilih
            });
        });
    </script>
@endsection
