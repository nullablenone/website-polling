@extends('layouts')

@section('content')
    <!-- Content -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1>{{ $polling->title }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('polling.vote', $polling->id) }}" method="POST" id="formVote" class="text-center">
                    @csrf
                    <strong>
                        <p>Klik tombol pilihan anda</p>
                    </strong>
                    <div class="mb-2"></div>
                    <div class="btn-group btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                        @foreach ($polling->jawaban as $jawaban)
                            <label class="btn btn-primary mb-2 rounded-2 mx-1">
                                <input type="radio" name="jawaban_id" value="{{ $jawaban->id }}" required>
                                {{ $jawaban->option }}
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Vote</button>
                </form>
                <div class="col-sm-12">
                    <div id="alert"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
