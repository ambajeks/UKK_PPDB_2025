# Quick Start Guide - Fitur Revisi Pendaftaran

## Instalasi (Sudah Dilakukan)

✅ Migration sudah dijalankan: `php artisan migrate`
✅ Model, Controller, Views, dan Routes sudah dibuat

## Testing Fitur Secara Manual

### Step 1: Buat Data Test

1. Login sebagai user normal (calon siswa)
2. Isi form pendaftaran lengkap
3. Upload dokumen
4. Lakukan pembayaran (status: Lunas)

### Step 2: Admin Memberikan Revisi

1. Login sebagai admin
2. Buka menu **Verifikasi**
3. Pilih calon siswa yang sudah bayar
4. Klik tombol **"Minta Revisi"** (kuning)
5. Pilih field yang perlu direvisi (minimal 1 field)
6. Tulis catatan revisi yang detail
7. Klik **"Kirim Permintaan Revisi"**
8. Cek database: data harus masuk ke tabel `revisi_pendaftaran` dengan status `menunggu`

### Step 3: User Melihat Notifikasi Revisi

1. Login sebagai calon siswa yang diberikan revisi
2. Buka halaman form pendaftaran (`/formulir`)
3. Lihat alert warning kuning dengan icon (!)
4. Alert menampilkan:
    - "Ada Permintaan Revisi dari Admin"
    - Catatan lengkap dari admin
    - Daftar field yang perlu direvisi

### Step 4: User Melakukan Revisi

1. Calon siswa mengisi kembali field yang ditandai
2. Perhatikan tombol submit berubah menjadi **"Simpan Revisi"**
3. Klik **"Simpan Revisi"**
4. Form harus terupdate
5. Cek database:
    - Status revisi di `revisi_pendaftaran` berubah menjadi `selesai`
    - Timestamp `selesai_at` terisi dengan waktu sekarang

### Step 5: Admin Verifikasi Ulang

1. Login sebagai admin
2. Buka menu **Verifikasi** lagi
3. Calon siswa yang sudah revisi muncul di daftar
4. Klik untuk melihat data yang sudah direvisi
5. Verifikasi atau minta revisi lagi jika masih ada yang kurang

---

## Troubleshooting

### Alert Revisi Tidak Muncul

- Pastikan sudah login sebagai calon siswa yang menerima revisi
- Cek apakah data ada di tabel `revisi_pendaftaran` dengan status `menunggu`
- Pastikan `formulir_id` di revisi_pendaftaran sesuai dengan formulir calon siswa

### Form Tidak Bisa Diedit Padahal Ada Revisi

- Cek di JavaScript console apakah variabel `adaRevisi` bernilai `true`
- Pastikan view menerima variable `revisiMenunggu` dari controller

### Data Revisi Tidak Tersimpan

- Cek apakah submit tombol di modal revisi berfungsi
- Lihat network tab di browser developer tools untuk POST request ke `/admin/verifikasi/{id}/revisi`
- Cek validation error di server logs

### Form Tidak Kembali Terkunci Setelah Revisi Selesai

- Ini adalah normal behavior - form akan kembali terkunci setelah admin memverifikasi
- Atau jika ada permintaan revisi baru, form akan aktif lagi

---

## Query SQL Berguna untuk Testing

```sql
-- Lihat semua revisi yang ada
SELECT * FROM revisi_pendaftaran;

-- Lihat revisi yang menunggu untuk formulir tertentu
SELECT * FROM revisi_pendaftaran
WHERE formulir_id = 1 AND status_revisi = 'menunggu';

-- Lihat field yang perlu direvisi
SELECT JSON_EXTRACT(field_revisi, '$[*]') as fields
FROM revisi_pendaftaran
WHERE id = 1;

-- Lihat calon siswa yang punya revisi menunggu
SELECT f.*, r.catatan_revisi, r.field_revisi
FROM formulir_pendaftaran f
JOIN revisi_pendaftaran r ON f.id = r.formulir_id
WHERE r.status_revisi = 'menunggu';
```

---

## API Testing dengan Postman (Jika Diperlukan)

### Endpoint: Minta Revisi

```
POST http://localhost/admin/verifikasi/1/revisi
Headers:
  Content-Type: application/x-www-form-urlencoded
  Cookie: XSRF-TOKEN=...; laravel_session=...

Body (form-data):
  _token: [CSRF_TOKEN]
  field_revisi[]: nama_lengkap
  field_revisi[]: nisn
  field_revisi[]: dokumen
  catatan_revisi: Nama lengkap harus sesuai KTP, NISN harus diisi, dokumen upload ulang
```

---

## Production Checklist

- [ ] Migration sudah dijalankan di production
- [ ] Semua file sudah di-deploy
- [ ] Composer autoload sudah di-update (`composer dump-autoload`)
- [ ] Cache sudah di-clear: `php artisan config:cache` dan `php artisan cache:clear`
- [ ] Testing fitur revisi di production environment
- [ ] Backup database sebelum menjalankan migration

---

**Notes**:

- Fitur ini mendukung multiple revisions (revisi bisa dilakukan berkali-kali)
- Setiap revisi baru akan membuat record baru di `revisi_pendaftaran`
- Field yang dirrevisi disimpan dalam format JSON array
- Timestamp `selesai_at` akan kosong sampai calon siswa submit revisi
