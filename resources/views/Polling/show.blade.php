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
                        <i class="fa fa-check-circle mr-2 text-light" aria-hidden="true"></i> Polling Terbaru
                    </a>
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa mr-2 fa-share-alt"></i>
                        Bagikan
                    </button>


                    {{-- --------------------------- fungsi share --------------------- --}}
                    <ul class="dropdown-menu">

                        <!-- WhatsApp -->
                        <li>
                            <a id="whatsappShare" class="dropdown-item d-flex align-items-center" href="#"
                                style="text-decoration: none;">
                                <i class="fab fa-whatsapp" style="font-size: 18px; color: #25D366; margin-right: 8px;"></i>
                                <span>Share via WhatsApp</span>
                            </a>
                        </li>

                        <!-- Telegram -->
                        <li>
                            <a id="telegramShare" class="dropdown-item d-flex align-items-center" href="#"
                                style="text-decoration: none;">
                                <i class="fab fa-telegram-plane"
                                    style="font-size: 18px; color: #0088cc; margin-right: 8px;"></i>
                                <span>Share via Telegram</span>
                            </a>
                        </li>

                        <!-- Facebook -->
                        <li>
                            <a id="facebookShare" class="dropdown-item d-flex align-items-center" href="#"
                                style="text-decoration: none;">
                                <i class="fab fa-facebook-f"
                                    style="font-size: 18px; color: #1877F2; margin-right: 8px;"></i>
                                <span>Share via Facebook</span>
                            </a>
                        </li>

                        <!-- Twitter -->
                        <li>
                            <a id="twitterShare" class="dropdown-item d-flex align-items-center" href="#"
                                style="text-decoration: none;">
                                <i class="fab fa-twitter" style="font-size: 18px; color: #1DA1F2; margin-right: 8px;"></i>
                                <span>Share via X (Twitter)</span>
                            </a>
                        </li>
                    </ul>



                </div>
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
        <a href="{{ route('polling.create') }}" class="btn mt-4 shadow" style="background-color: #00BFFF; color: white;">
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
    </script>
@endsection
