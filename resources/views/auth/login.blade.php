@extends('layouts.app')

@section('title', 'login')
@section('content')
    <div class="card">
        <div class="card-body">

            <h4 class="mb-2" style="color: #008374">Selamat Datang! 👋</h4>
            <p class="mb-4">Silakan masuk dan mulai membuat mengikuti polling.</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: #008374">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="{{ __('Masukkan email mu') }}" value="{{ old('email') }}" required
                        autocomplete="off" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password" style="color: #008374">Password</label>
                        <a href="{{ route('password.request') }}">
                            <small>{{ __('Lupa kata sandi Anda?') }}</small>
                        </a>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="············" required autocomplete="current-password" autocomplete="off">
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Ingat saya') }}
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit"
                        style="background-color: #008374">{{ __('Masuk') }}</button>
                </div>
            </form>

            <p class="text-center">
                <span>Baru bergabung?</span>
                <a href="{{ route('register') }}">
                    <span>{{ __('Daftar sekarang!') }}</span>
                </a>
            </p>
        </div>
    </div>
@endsection
