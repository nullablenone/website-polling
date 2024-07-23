@extends('layouts')
@section('title', 'Tentang Kami')
@section('content')
    <div class="container mt-5 d-flex flex-column justify-content-between" style="min-height: 80vh;">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center">
                <h2 class="mb-4">Kontak Kami</h2>
                <p class="lead">Kami senang mendengar dari Anda! Jika Anda memiliki pertanyaan atau ingin berbagi
                    pemikiran, silakan hubungi kami melalui email atau media sosial di bawah ini. Kami akan berusaha untuk
                    merespons secepat mungkin.</p>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-6 text-center mb-3">
                <h4>Email</h4>
                <p><a href="mailto:info@useryesa9.com">useryesa9@gmail.com</a></p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-3">
                <h4>Media Sosial</h4>
                <p>Ikuti kami di Instagram:</p>
                <a href="https://www.instagram.com/nullablenone/" class="btn btn-outline-danger btn-sm mx-1"
                    target="_blank">
                    <i class="fa fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </div>
@endsection
