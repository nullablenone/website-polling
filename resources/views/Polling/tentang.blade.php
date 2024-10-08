@extends('layouts')
@section('title', 'Tentang Saya')
@section('content')
    <div class="container mt-5 d-flex flex-column justify-content-between shadow-lg" style="min-height: 80vh;">
        <!-- Bagian Tentang Web Polling -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 p-4 shadow-sm">
                <h2 class="mb-4 fw-bold text-center">Tentang Website Polling</h2>
                <p class="lead text-center">Website polling ini dirancang untuk memudahkan pengguna dalam memberikan suara
                    dan berpartisipasi dalam berbagai polling. Dengan tampilan yang sederhana dan responsif, pengguna dapat
                    dengan mudah membuat dan mengikuti polling yang menarik, serta melihat hasil secara real-time.
                    Kami percaya bahwa suara setiap individu sangat penting dan website ini bertujuan untuk memberi
                    platform bagi setiap orang untuk berbagi pendapat mereka.</p>
            </div>
        </div>

        <!-- Bagian Tentang Saya dengan Foto di Samping -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 p-4 shadow-sm">
                <div class="row align-items-center">
                    <!-- Bagian Foto -->
                    <div class="col-md-4 text-center">
                        <img src="{{ asset('assets/images/me.jpg') }}" alt="Foto Muhamad Yesa" class="img-fluid shadow-sm"
                            style="max-width: 150px;">
                    </div>

                    <!-- Bagian Deskripsi -->
                    <div class="col-md-8">
                        <h2 class="mb-4 fw-bold text-center text-md-start">Tentang Saya</h2>
                        <p class="lead text-center text-md-start">Halo! Nama saya <strong>Muhamad Yesa</strong>, dan saya
                            adalah
                            pencipta website polling ini. Sebagai seorang pelajar yang memiliki minat dalam dunia
                            pemrograman
                            web development, saya selalu berusaha untuk belajar dan berkembang. Saat ini, saya fokus pada
                            pengembangan web dan memiliki hobi bermain game yang membantu saya dalam berpikir kreatif dan
                            menemukan solusi baru.</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bagian Media Sosial -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center mb-3">
                <h4 class="fw-bold">Ikuti Saya di Media Sosial</h4>
                <a href="https://www.instagram.com/nullablenone/" class="btn btn-danger btn-sm mx-1 shadow-sm fw-bold"
                    target="_blank">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
                <a href="https://www.linkedin.com/in/muhamad-yesa/" class="btn btn-primary btn-sm mx-1 shadow-sm fw-bold"
                    target="_blank">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a>
            </div>
        </div>
    </div>
@endsection
