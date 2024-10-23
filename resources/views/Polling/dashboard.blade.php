    @extends('layouts')
    @section('title', 'Dashboard')
    @section('content')
        <div style="min-height: 400px;" class="mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title text-center mb-5 p-4 text-white rounded shadow-lg">
                            <h2 class="text-uppercase" style="letter-spacing: 2px;">Dashboard</h2>
                        </div>
                        <div class="text-right mb-3">
                            <a href="{{ route('polling.create') }}" class="btn btn-primary">BUAT POLLING BIASA</a>
                            <a href="#" class="btn btn-warning">BUAT POLLING PREMIUM</a>
                        </div>

                        <div class="card border-success shadow-sm">

                            <div class="card-body">

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @foreach ($pollings as $polling)
                                    <div class="card mb-4 polling-item border-0 shadow-sm rounded-lg">
                                        <div
                                            class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-4">
                                            <div class="mb-3 mb-md-0">
                                                <a href="{{ route('polling.show', $polling->id) }}" class="h4 fw-bold"
                                                    style="color: #007BFF; transition: color 0.3s;"
                                                    onmouseover="this.style.color='#0056b3';"
                                                    onmouseout="this.style.color='#007BFF';">
                                                    {{ $polling->title }}
                                                </a>
                                                <div class="text-muted">Dibuat pada
                                                    {{ $polling->created_at->format('d m Y') }}</div>
                                            </div>
                                            <div class="mt-3 text-center">

                                                <a href="{{ route('polling.tutup', $polling->id) }}"
                                                    class="btn btn-sm btn-outline-info mr-2">Tutup</a>

                                                <form action="{{ route('polling.hapus', $polling->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus polling ini?');">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endsection
