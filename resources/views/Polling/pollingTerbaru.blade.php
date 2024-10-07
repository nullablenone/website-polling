@extends('layouts')
@section('title', 'Polling Terbaru')
@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="section-title text-center mb-5 p-4 bg-gradient text-white rounded shadow">
            <h1 class="fw-bold">Polling Terbaru</h1>
        </div>

        <hr>

        @foreach ($pollings as $polling)
            <div class="card mb-4 polling-item shadow-lg border-0 rounded">
                <div
                    class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-4">
                    <div class="mb-3 mb-md-0">
                        <a href="{{ route('polling.show', $polling->id) }}"
                            class="h4 text-success fw-bold">{{ $polling->title }}</a>
                        <div class="text-muted">Dibuat pada {{ $polling->created_at->format('d-m-Y') }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
