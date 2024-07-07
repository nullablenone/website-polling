@extends('layouts')

@section('content')
    <!-- Content -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="">{{ $polling->title }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <p class="fs-6 fw-bold">Klik tombol pilihan anda</p>
                    <div class="mb-2"></div>
                    <div class="btn-group btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                        @foreach ($polling->jawaban as $jawaban)
                            <label class="btn btn-primary mb-2 rounded-2 mx-1 py-2">
                                <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required>
                                <span class="fw-bold fs-5">{{ $jawaban->option }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="py-2 px-4 btn btn-success mt-3 fw-bold">Vote</button>
                </form>
                <div class="col-sm-12">
                    <div id="alert"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
