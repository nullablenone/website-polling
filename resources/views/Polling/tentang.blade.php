@extends('layouts')
@section('title', 'Tentang Kami')
@section('content')
    <div class="container mt-5 d-flex flex-column justify-content-between" style="min-height: 80vh;">
        <!-- Header Tanpa Background Khusus -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 text-center p-4 shadow-sm">
                <h2 class="mb-4 fw-bold">Kontak Kami</h2>
                <p class="lead">Kami senang mendengar dari Anda! Jika Anda memiliki pertanyaan atau ingin berbagi
                    pemikiran,
                    silakan hubungi kami melalui email atau media sosial di bawah ini. Kami akan berusaha untuk merespons
                    secepat mungkin.</p>
            </div>
        </div>

        <!-- Bagian Email -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-6 text-center mb-3">
                <h4 class="fw-bold">Email</h4>
                <p><a href="mailto:info@useryesa9.com"
                        class="text-decoration-none text-success fw-bold">useryesa9@gmail.com</a></p>
            </div>
        </div>

        <!-- Bagian Media Sosial -->
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-3">
                <h4 class="fw-bold">Media Sosial</h4>
                <p>Ikuti kami di Instagram:</p>
                <a href="https://www.instagram.com/nullablenone/" class="btn btn-danger btn-sm mx-1 shadow-sm fw-bold"
                    target="_blank">
                    <i class="fa fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </div>
@endsection
