@extends('layouts')

@section('content')
    <div class="container mt-5">
        <div class="section-title text-center mb-4">
            <h1>Polling Tersimpan</h1>
        </div>
        <hr>
        @foreach ($pollings as $polling)
            <div class="card mb-3 polling-item">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('polling.show', $polling->id) }}" class="h5 text-primary">{{ $polling->title }}</a>
                        <div class="text-muted">Dibuat {{ $polling->created_at->format('d-m-Y') }}</div>
                    </div>
                    <button class="btn btn-danger" type="button" onclick="delFav({{ $polling->id }})">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
