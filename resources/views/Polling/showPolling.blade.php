@extends('layouts')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">{{ $polling->title }} ?</h1>
            <div class="card shadow-lg">
                <ul class="list-group list-group-flush" id="bar">
                    @php
                        // Menghitung total suara dari semua jawaban
                        $totalVotes = $polling->jawaban->sum('vote');
                    @endphp
                    @foreach ($polling->jawaban as $jawaban)
                        @php
                            // Menghitung persentase suara untuk setiap jawaban
                            // Jika totalVotes > 0, hitung persentase, jika tidak, persentase adalah 0
                            $percentage = $totalVotes > 0 ? ($jawaban->vote / $totalVotes) * 100 : 0;
                        @endphp
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ $jawaban->option }}</span>
                                <span class="badge badge-primary">{{ $jawaban->vote }} Suara</span>
                            </div>
                            <div class="progress mt-2" style="height: 25px;">
                                <!-- Mengatur lebar progress bar berdasarkan persentase yang telah dihitung -->
                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: {{ $percentage }}%;"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ number_format($percentage, 2) }}%
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="card-footer text-center bg-light">
                    <!-- Menampilkan total suara -->
                    <h5>Total: <span id="spanCount">{{ $totalVotes }}</span> suara</h5>
                </div>
            </div>
        </div>
    </div>
@endsection