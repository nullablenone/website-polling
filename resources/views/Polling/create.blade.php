@extends('layouts')
@section('title', 'Buat Polling')
@section('content')
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- Form untuk polling -->
        <form id="pollingForm" class="form mt-5" action="{{ route('polling.store') }}" method="POST">
            <div class="card shadow-lg border-0 rounded">
                <!-- CSRF Token -->
                @csrf

                <!-- Section Title -->
                <div class="section-title text-center mb-5 p-4 text-white rounded shadow-lg">
                    <h2 class="text-uppercase" style="letter-spacing: 2px;">Buat polling sendiri</h2>
                </div>




                <div class="card-body p-4">
                    <!-- Input pertanyaan -->
                    <div class="form-group mb-4">
                        <label for="title" class="h6">Pertanyaan</label>
                        <textarea name="title" class="form-control @error('title') is-invalid @enderror" id="title" autofocus="on"
                            required maxlength="160" cols="30" rows="2"></textarea>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="char-counter text-muted" id="charCounter">160 characters remaining</div>
                    </div>

                    <!-- Input pilihan pertama -->
                    <div class="form-group mb-3">
                        <label for="option1" class="h6">Ketikan Pilihan Dibawah Ini</label>
                        <input type="text" name="option[]" class="form-control shadow-sm" id="option1" required
                            placeholder="Pilihan" autocomplete="off">
                    </div>

                    <!-- Input pilihan kedua -->
                    <div class="form-group mb-3">
                        <input type="text" name="option[]" class="form-control shadow-sm" id="option2" required
                            placeholder="Pilihan" autocomplete="off">
                    </div>

                    <!-- Tempat untuk input tambahan -->
                    <div id="additionalOptions"></div>

                    <!-- Tombol untuk menambah input -->
                    <button type="button" id="addOptionBtn" class="btn btn-outline-secondary mb-3 fw-bold shadow-sm">
                        <i class="fa fa-plus"></i> Tambah Option
                    </button>
                </div>

                <div class="card-footer text-center bg-light">
                    <!-- Tombol submit -->
                    <button type="submit" class="btn btn-success pl-5 pr-5 mt-2 fw-bold shadow-sm">
                        <i class="fa fa-paper-plane mr-2"></i> Buat Polling
                    </button>
                </div>

                <div class="alert alert-warning my-4 text-center">
                    <b>Perhatian:</b> Dilarang membuat Polling yang berbau Provokasi, Radikalisme, dan SARA
                </div>
                <a href="{{ route('polling.pollingFoto') }}"
                    class="btn shadow-sm px-4 py-2 align-items-center fw-bold text-white" style="background: #008374">
                    <i class="fas fa-plus me-2 text-white"></i> Buat Polling Foto
                </a>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxLength = 160;

            updateCharCounter(document.getElementById('title').value.length);

            document.getElementById('title').addEventListener('input', function() {
                const length = this.value.length;
                updateCharCounter(length);
            });

            function updateCharCounter(length) {
                const remaining = maxLength - length;
                document.getElementById('charCounter').textContent = remaining + ' characters remaining';
            }

            let optionCount = 2;

            document.getElementById('addOptionBtn').addEventListener('click', function() {
                optionCount++;

                const newOption = `
            <div class="form-group mb-3" id="option${optionCount}Wrapper">
                <div class="input-group shadow-sm">
                    <input type="text" name="option[]" class="form-control" id="option${optionCount}" required placeholder="Pilihan" autocomplete="off">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(${optionCount})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>`;

                const wrapper = document.createElement('div');
                wrapper.innerHTML = newOption.trim();
                document.getElementById('additionalOptions').appendChild(wrapper.firstChild);
            });

            window.removeOption = function(optionNumber) {
                const wrapper = document.getElementById(`option${optionNumber}Wrapper`);
                if (wrapper) {
                    wrapper.remove();
                }
            };
        });

        // SweetAlert konfirmasi submit
        document.getElementById('pollingForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form langsung

            swal({
                title: "Yakin ingin membuat polling?",
                text: "Kamu tidak bisa mengubah polling ini nanti.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    this.submit(); // Submit form kalau user konfirmasi
                }
            });
        });
    </script>
@endsection
