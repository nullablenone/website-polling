@extends('layouts.app')

@section('title', 'login')

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

            <h4 class="mb-2" style="color: #008374">Ayo mulai! 🚀</h4>
            <p class="mb-4">Bikin pengelolaan pollingmu jadi lebih gampang dan seru!</p>

            <!-- Form Register -->
            <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                @csrf
                <!-- Username Input -->
                <div class="mb-3">
                    <label for="username" class="form-label" style="color: #008374">Username</label>
                    <input type="text" class="form-control" id="username" name="name" placeholder="Masukan username"
                        autofocus value="{{ old('name') }}" autocomplete="off">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: #008374">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email mu"
                        value="{{ old('email') }}" autocomplete="off">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password" style="color: #008374">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="············" value="{{ old('password') }}" autocomplete="off">
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password-confirm" style="color: #008374">Konfirmasi Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation"
                            placeholder="············" value="{{ old('password_confirmation') }}" autocomplete="off">
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                </div>

                <!-- Register Button -->
                <button class="btn btn-primary d-grid w-100" style="background-color: #008374">Daftar</button>
            </form>


            <p class="text-center">
                <span>Udah punya akun?</span>
                <a href="{{ route('login') }}">
                    <span>Masuk aja</span>
                </a>
            </p>
        </div>
    </div>
@endsection
