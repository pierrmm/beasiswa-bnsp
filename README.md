# Sistem Pendaftaran Beasiswa Online

Aplikasi web berbasis Laravel untuk mengelola proses pendaftaran beasiswa kampus secara digital. Mahasiswa dapat melihat jenis beasiswa, mengisi formulir pendaftaran, dan memantau status ajuan secara terpadu.

## Fitur Utama
- Halaman utama yang menampilkan jenis beasiswa beserta syaratnya.
- Form pendaftaran dengan validasi lengkap dan pengisian IPK otomatis dari konstanta sistem.
- Upload berkas pendukung ke storage publik (`storage/app/public/berkas_beasiswa`).
- Logika khusus yang menonaktifkan form bila IPK < 3.00 dan mengaktifkannya lengkap dengan fokus otomatis bila IPK ≥ 3.00.
- Halaman hasil pendaftaran untuk melihat seluruh ajuan beserta link berkas dan status.

## Teknologi yang Digunakan
- [Laravel 12.x](https://laravel.com/) + PHP 8.2
- Blade Template + Bootstrap 5 melalui CDN
- Storage Laravel (disk `public`) untuk unggah berkas
- Eloquent ORM untuk akses database

## Persiapan & Instalasi
1. **Buat project Laravel baru**
   ```bash
   composer create-project laravel/laravel beasiswa
   cd beasiswa
   ```
2. **Salin file environment dan generate key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. **Siapkan database**
   - Buat database kosong di MySQL/MariaDB, misalnya `beasiswa_db`.
   - Perbarui pengaturan di `.env`:
     ```env
     DB_DATABASE=beasiswa_db
     DB_USERNAME=root
     DB_PASSWORD=secret
     ```
4. **Jalankan migration & seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   Migration akan membuat tabel `scholarship_applications`, sedangkan `ScholarshipApplicationSeeder` menambahkan contoh data.
5. **Aktifkan tautan storage publik**
   ```bash
   php artisan storage:link
   ```
6. **Jalankan server pengembangan**
   ```bash
   php artisan serve
   ```
7. **Buka aplikasi** di browser melalui `http://127.0.0.1:8000`.

## Cara Menggunakan Aplikasi
1. **Jenis Beasiswa** – halaman utama (`/`) menampilkan daftar beasiswa akademik dan non-akademik, lengkap dengan syarat.
2. **Daftar Beasiswa** – halaman `/daftar` memuat form. Sistem otomatis mengisi nilai IPK dan mengatur apakah field dapat digunakan.
3. **Upload Berkas & Kirim** – jika IPK ≥ 3.00, pilih jenis beasiswa, unggah berkas PDF/JPG/PNG/ZIP, lalu klik *Daftar*. Data akan tersimpan dengan status "belum diverifikasi".
4. **Hasil Pendaftaran** – halaman `/hasil` menampilkan seluruh ajuan beserta IPK, jenis beasiswa, link unduhan berkas, dan status terbaru.

## Mengubah Konstanta IPK
- Aplikasi secara otomatis memilih salah satu nilai IPK dari array `gpa_values` di `config/scholarship.php`. Default-nya `[3.40, 2.90]` sehingga Anda bisa merasakan skenario memenuhi dan tidak memenuhi syarat.
- Jika ingin satu nilai saja, cukup sisakan satu angka pada array tersebut atau ubah `gpa_value` sebagai fallback. Contoh:
```php
return [
    'gpa_value' => 3.10,
    'gpa_values' => [3.10],
    // ...
];
```
Perubahan dapat langsung dicoba tanpa memodifikasi database.

## Catatan Tambahan
- Direktori upload berkas berada di `storage/app/public/berkas_beasiswa`. Pastikan izin tulis tersedia.
- Jalankan `npm install && npm run dev` bila ingin menambahkan asset melalui Vite, meskipun template default sudah menggunakan Bootstrap via CDN.
- Gunakan `php artisan migrate:fresh --seed` saat ingin mengulang seluruh data pendaftaran dari awal.
