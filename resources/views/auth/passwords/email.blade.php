@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('logo.svg') }}" alt="" class="img-fluid" style="width: 100%; height: 50px;">
                    </span>
                </a>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <h4 class="mb-2" style="color: #008374">Lupa Password? 🔒</h4>
            <p class="mb-4">Masukan Email mu dan kami akan mengirim instruksi untuk mengatur ulang password.</p>
            <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: #008374">Email</label>
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email"
                        value="{{ old('email') }}" required name="email" placeholder="Masukan email mu"
                        autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100" style="background-color: #008374">Reset
                    Password</button>
            </form>
            <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                    <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
