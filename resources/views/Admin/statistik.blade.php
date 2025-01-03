@extends('admin-layouts')
@section('title', 'Statistik')
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User /</span> Statistik</h4>

    <div class="card">
        <h5 class="card-header">Statistik User</h5>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>ip address</th>
                        <th>Total Polling</th>
                        <th>Max Polling</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($filteredUsers->zip($batas_polling) as [$user, $batas])
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->ip_address }}</td>
                            <td>{{ $batas ? $batas->jumlah_polling : 0 }}</td>
                            <td>{{ $batas ? $batas->batas_polling : 3 }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.update', $user->id) }}" class="dropdown-item"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Update</a>
                                        <form action="{{ route('admin.hapus', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
