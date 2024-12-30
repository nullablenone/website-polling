# Website Polling

Website ini adalah platform untuk membuat dan mengelola polling, dirancang menggunakan Laravel dan beberapa teknologi pendukung.

## 🎯 Tujuan Proyek

Menyediakan platform untuk membuat polling interaktif, baik polling teks maupun foto, dengan fitur-fitur untuk user dan admin.

## ✨ Fitur Utama

### Fitur untuk User

- **Login**: Otentikasi menggunakan Laravel UI.  
- **Membuat Polling**: Dukungan untuk polling biasa dan polling foto.  
- **Dashboard User**: Melihat daftar polling yang dibuat, menghapus, menutup polling.  
- **Voting**: Memberikan suara pada polling yang dibuat oleh user lain.  

### Fitur untuk Admin

- **Dashboard Admin**: Mengelola daftar user dan jumlah polling yang dibuat oleh masing-masing user.  
- **Pembatasan Polling**: Membatasi jumlah polling yang dapat dibuat oleh user. Admin memiliki kontrol untuk mengizinkan user membuat polling tambahan. Sistem pembatasan ini bekerja berdasarkan IP address dan per akun, sehingga secara otomatis mengatasi masalah spam dengan banyak akun.

**Catatan**: Beberapa fitur admin masih dalam tahap pengembangan.

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel dengan Laravel UI untuk otentikasi.  
- **Role Management**: Laravel Spatie Role Permission.  
- **Frontend**: Bootstrap dan JavaScript.  
- **Interaktivitas**: Sweet Alert.  

## 🚀 Cara Menjalankan Proyek

1. Clone repositori ini:  
   ```bash
   git clone <repository-url>
   cd <repository-folder>
   ```

2. Install dependencies:  
   ```bash
   composer install
   npm install
   ```

3. Buat file `.env` dan atur konfigurasi database. Lalu jalankan:  
   ```bash
   php artisan migrate --seed
   ```

4. Jalankan server:  
   ```bash
   php artisan serve
   ```

5. Akses aplikasi di `http://localhost:8000`.

## 🚧 Status Proyek

Proyek ini masih dalam tahap pengembangan, terutama untuk fitur admin.
