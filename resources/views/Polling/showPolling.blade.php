@extends('layouts')
@section('content')
    <h1>{{ $polling->title }}</h1>

    @foreach ($polling->jawaban as $jawaban)
        <h2>{{ $jawaban->option }}</h2>
        <p>{{ $jawaban->vote }}</p>
    @endforeach
@endsection
