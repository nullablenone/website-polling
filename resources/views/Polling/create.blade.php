@extends('layouts')

@section('content')
    <div class="container mt-5">

        <!-- Section Title -->
        {{-- <div class="container section-title mt-5" data-aos="fade-up">
            <h2>Buat Polling Anda sendiri</h2>
        </div><!-- End Section Title --> --}}

        <!-- Form untuk polling -->
        <form id="pollingForm" class="php-email form mt-5 container" action="{{ route('polling.store') }}" method="POST">
            <div class="row gy-1" data-aos="fade-up" data-aos-delay="100">
                <!-- CSRF Token -->
                @csrf


                <div class="card">
                    {{-- form input pertanyaan --}}
                    <div class="form-group">
                        <div class="card-header text-center">
                            <h1>Buat Polling Sendiri</h1>
                        </div>
                        <label for="" class=""><b>Pertanyaan</b></label>
                        <textarea name="title" class="form-control" id="title" autofocus="on" required maxlength="160" cols="30"
                            rows="2"></textarea>
                        <div class="char-counter" id="charCounter">160 characters remaining</div>
                    </div>

                    <!-- Input pertama -->
                    <div class="form-group">
                        <label for="title"><b>Ketikan Pilihan Dibawah Ini</b></label>
                        <input type="text" name="option[]" class="form-control" id="option1" required
                            placeholder="Pillihan" autocomplete="off">
                    </div>

                    <!-- Input kedua -->
                    <div class="form-group">
                        <input type="text" name="option[]" class="form-control" id="option2" required
                            placeholder="Pillihan" autocomplete="off">
                    </div>

                    <!-- Tempat untuk input tambahan -->
                    <div id="additionalOptions"></div>

                    <!-- Tombol untuk menambah input -->
                    <button type="button" id="addOptionBtn" class="btn btn-primary mb-3 fw-bold">Tambah Option +</button>

                    <div class="text-center mt-5">
                        <!-- Tombol submit -->
                        <button type="submit" class="btn btn-success pl-5 pr-5 mt-2 fw-bold"><i
                                class="fa mr-2 fa-paper-plane"></i>
                            Buat
                            Polling</button>
                        {{-- Tombol setting --}}
                        <button type="button" name="advance" class="btn btn-default mt-2" data-toggle="collapse"
                            data-target="#el_advanced"><i class="fa mr-2 fa-cog"></i> Setting Tambahan</button>
                    </div>
                    <br>
                    <div class="alert alert-info my-4"><b>Perhatian:</b> Dilarang membuat Polling yang berbau Provokasi,
                        Radikalisme dan
                        SARA</div>
                </div>
            </div>
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- JavaScript -->
    <script>
        // fungsi untuk menghitung sisa karakter di textarea
        document.addEventListener('DOMContentLoaded', function() {
            // Max karakter yang diizinkan
            const maxLength = 160;

            // Update sisa karakter saat halaman pertama kali dimuat
            updateCharCounter(document.getElementById('title').value.length);

            // Event listener untuk input title
            document.getElementById('title').addEventListener('input', function() {
                const length = this.value.length;
                updateCharCounter(length);
            });

            // Fungsi untuk update sisa karakter
            function updateCharCounter(length) {
                const remaining = maxLength - length;
                document.getElementById('charCounter').textContent = remaining + ' characters remaining';
            }


            // Fungsi untuk menambahkan Button
            let optionCount = 2; // Dimulai dari 2 karena sudah ada 2 input awal

            // Event listener untuk tombol "Add Option"
            document.getElementById('addOptionBtn').addEventListener('click', function() {
                optionCount++; // Tambah jumlah input

                // HTML untuk input baru beserta tombol delete
                const newOption = `
            <div class="form-group" id="option${optionCount}Wrapper">
                <div class="input-group">
                    <input type="text" name="option[]" class="form-control" id="option${optionCount}" required placeholder="Pilihan" autocomplete="off">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger" onclick="removeOption(${optionCount})">Delete</button>
                    </div>
                </div>
            </div>`;

                // Buat elemen div baru
                const wrapper = document.createElement('div');
                wrapper.innerHTML = newOption.trim();

                // Tambahkan input baru ke dalam div #additionalOptions
                document.getElementById('additionalOptions').appendChild(wrapper.firstChild);
            });

            // Fungsi untuk menghapus input field
            window.removeOption = function(optionNumber) {
                const wrapper = document.getElementById(`option${optionNumber}Wrapper`);
                if (wrapper) {
                    wrapper.remove(); // Hapus div input wrapper sesuai dengan nomor input
                }
            };
        });
    </script>
@endsection
