@extends('layouts')
@section('title', 'Mulai Polling Baru')
@section('content')
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger shadow-sm text-center">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif
        
        <form id="pollingForm" class="form mt-5" action="{{ route('polling.store') }}" method="POST">
            <div class="card shadow-lg border-0">
                <!-- CSRF Token -->
                @csrf

                <!-- Section Title / Card Header -->
                <div class="card-header text-center py-4">
                    <h2 class="m-0" style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600;">Mulai Polling Baru</h2>
                </div>

                <div class="card-body p-4">
                    <!-- Input pertanyaan -->
                    <div class="form-group mb-4">
                        <label for="title" class="h6 mb-2 text-white-50">Topik atau Pertanyaan Utama</label>
                        <textarea name="title" class="form-control @error('title') is-invalid @enderror" id="title" autofocus="on"
                            required maxlength="160" cols="30" rows="3" placeholder="Tuliskan topik atau pertanyaan utama di sini..."></textarea>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="char-counter text-muted mt-2 text-end" id="charCounter">160 karakter tersisa</div>
                    </div>

                    <!-- Input pilihan pertama -->
                    <div class="form-group mb-3">
                        <label for="option1" class="h6 mb-2 text-white-50">Pilihan Jawaban</label>
                        <input type="text" name="option[]" class="form-control" id="option1" required
                            placeholder="Opsi pertama" autocomplete="off">
                    </div>

                    <!-- Input pilihan kedua -->
                    <div class="form-group mb-3">
                        <input type="text" name="option[]" class="form-control" id="option2" required
                            placeholder="Opsi kedua" autocomplete="off">
                    </div>

                    <!-- Tempat untuk input tambahan -->
                    <div id="additionalOptions"></div>

                    <!-- Tombol untuk menambah input -->
                    <button type="button" id="addOptionBtn" class="btn btn-outline-secondary mt-3 fw-bold d-flex align-items-center gap-2">
                        <i class="fa fa-plus"></i> Tambah Opsi Jawaban
                    </button>
                </div>

                <div class="card-footer text-center py-4">
                    <!-- Tombol submit -->
                    <button type="submit" class="btn btn-success px-5 py-3 fw-bold">
                        <i class="fa fa-paper-plane me-2"></i> Publikasikan Polling
                    </button>
                </div>

                <div class="alert alert-warning m-4 text-center">
                    <i class="fas fa-info-circle me-2"></i> <b>Catatan Penting:</b> Hindari membuat polling yang bersifat provokatif, radikal, atau mengandung SARA.
                </div>
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
                document.getElementById('charCounter').textContent = remaining + ' karakter tersisa';
            }

            let optionCount = 2;

            document.getElementById('addOptionBtn').addEventListener('click', function() {
                optionCount++;

                const newOption = `
            <div class="form-group mb-3" id="option${optionCount}Wrapper" style="opacity: 0; transform: translateY(5px); transition: all 0.2s ease-out;">
                <div class="input-group">
                    <input type="text" name="option[]" class="form-control" id="option${optionCount}" required placeholder="Opsi Pilihan ${optionCount}" autocomplete="off">
                    <button type="button" class="btn btn-outline-danger border-0 px-3 d-flex align-items-center justify-content-center" onclick="removeOption(${optionCount})" style="border-radius: 0 4px 4px 0 !important; color: #f43f5e !important; border-left: 1px solid #27272a !important;">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>`;

                const wrapper = document.createElement('div');
                wrapper.innerHTML = newOption.trim();
                const element = wrapper.firstChild;
                document.getElementById('additionalOptions').appendChild(element);
                
                // Trigger transition
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 10);
            });

            window.removeOption = function(optionNumber) {
                const wrapper = document.getElementById(`option${optionNumber}Wrapper`);
                if (wrapper) {
                    wrapper.style.opacity = '0';
                    wrapper.style.transform = 'translateY(5px)';
                    setTimeout(() => {
                        wrapper.remove();
                    }, 200);
                }
            };
        });
    </script>
@endsection
