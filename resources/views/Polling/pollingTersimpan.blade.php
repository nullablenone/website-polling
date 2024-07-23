@extends('layouts')
@section('title', 'Polling Tersimpan')
@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="section-title text-center mb-4">
            <h1>Polling Tersimpan</h1>
        </div>
        <hr>
        @foreach ($pollings as $polling)
            <div class="card mb-3 polling-item shadow-sm">
                <div
                    class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-2 mb-md-0">
                        <a href="{{ route('polling.show', $polling->id) }}" class="h5 text-primary">{{ $polling->title }}</a>
                        <div class="text-muted">Dibuat {{ $polling->created_at->format('d-m-Y') }}</div>
                    </div>
                    <form action="{{ route('polling.destroy', $polling->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
