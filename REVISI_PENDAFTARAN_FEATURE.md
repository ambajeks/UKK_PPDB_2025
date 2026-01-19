# Dokumentasi Fitur Revisi Pendaftaran PPDB

## Ringkasan Fitur

Fitur revisi pendaftaran memungkinkan admin untuk meminta calon siswa melakukan perbaikan data pendaftaran sebelum verifikasi final. Jika ada kesalahan atau data yang tidak lengkap, admin dapat menginformasikan field mana saja yang perlu diperbaiki, dan calon siswa dapat melakukan revisi melalui form pendaftaran.

---

## Workflow Revisi Pendaftaran

### 1. **Admin Melakukan Verifikasi**

- Admin membuka detail calon siswa di halaman verifikasi (`/admin/verifikasi/{id}`)
- Admin dapat memilih 3 aksi:
    - ✅ **Verifikasi & Terima** - Menerima pendaftaran
    - ⚠️ **Minta Revisi** - Meminta perbaikan data
    - ❌ Tolak - Menolak pendaftaran

### 2. **Admin Meminta Revisi**

- Admin klik tombol **"Minta Revisi"** (warna kuning)
- Modal akan muncul dengan pilihan:
    - **Daftar field** yang perlu diperbaiki (checkbox):
        - Nama Lengkap
        - NISN
        - Jenis Kelamin
        - Tempat Lahir
        - Tanggal Lahir
        - Asal Sekolah
        - Agama
        - NIK
        - Anak Ke-
        - Alamat
        - Desa
        - Kelurahan
        - Kecamatan
        - Kota
        - No. HP
        - Dokumen
    - **Catatan Revisi**: Penjelasan detail tentang apa yang perlu diperbaiki
- Admin klik **"Kirim Permintaan Revisi"**
- Data revisi disimpan ke tabel `revisi_pendaftaran`

### 3. **Calon Siswa Melihat Notifikasi Revisi**

- Calon siswa login dan membuka form pendaftaran (`/formulir`)
- Muncul **alert warning** berwarna kuning dengan icon (!) yang menyatakan:
    - "Ada Permintaan Revisi dari Admin"
    - Menampilkan catatan dari admin
    - Menampilkan daftar field yang perlu direvisi
- Form pendaftaran menjadi **aktif/editable** meski sudah bayar

### 4. **Calon Siswa Melakukan Revisi**

- Calon siswa mengisi ulang field-field yang ditandai
- Tombol submit berubah menjadi **"Simpan Revisi"** (dari "Simpan Formulir")
- Setelah klik "Simpan Revisi":
    - Data formulir diperbarui
    - Status revisi di tabel `revisi_pendaftaran` berubah menjadi `selesai`
    - Timestamp `selesai_at` diset ke waktu sekarang

### 5. **Admin Melakukan Verifikasi Ulang**

- Calon siswa muncul di daftar verifikasi lagi
- Admin melihat form yang sudah direvisi
- Admin dapat:
    - ✅ Verifikasi & Terima (jika sudah benar)
    - ⚠️ Minta Revisi lagi (jika masih ada yang salah)

---

## Database Schema

### Tabel: `revisi_pendaftaran`

```sql
CREATE TABLE revisi_pendaftaran (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    formulir_id BIGINT NOT NULL (FK -> formulir_pendaftaran.id),
    admin_id BIGINT NOT NULL (FK -> users.id),
    field_revisi JSON NOT NULL,          -- Array field yang perlu direvisi
    catatan_revisi TEXT NOT NULL,        -- Catatan detail dari admin
    status_revisi ENUM('menunggu', 'selesai') DEFAULT 'menunggu',
    selesai_at TIMESTAMP NULL,           -- Waktu calon siswa menyelesaikan revisi
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## File-File yang Dimodifikasi/Dibuat

### 1. **Database Migration**

- `database/migrations/2025_01_19_000000_create_revisi_pendaftaran_table.php` ✨ **BARU**
- Membuat tabel `revisi_pendaftaran`

### 2. **Models**

- `app/Models/RevisiPendaftaran.php` ✨ **BARU**
    - Model untuk tabel revisi
    - Relasi dengan FormulirPendaftaran dan User
    - Helper methods: `isMenunggu()`, `isSelesai()`

- `app/Models/FormulirPendaftaran.php` 🔄 **DIUPDATE**
    - Tambah relasi: `revisi()` untuk hasMany RevisiPendaftaran
    - Helper methods baru:
        - `hasRevisiMenunggu()` - Cek apakah ada revisi menunggu
        - `getRevisiMenunggu()` - Ambil revisi terbaru yang menunggu

### 3. **Controllers**

- `app/Http/Controllers/VerifikasiController.php` 🔄 **DIUPDATE**
    - Tambah method `mintaRevisi(Request $request, $id)`
    - Validasi field revisi yang dipilih
    - Simpan ke tabel revisi_pendaftaran

- `app/Http/Controllers/FormulirPendaftaranController.php` 🔄 **DIUPDATE**
    - Update method `index()` untuk pass `revisiMenunggu` ke view
    - Update method `store()` untuk handle revisi:
        - Ketika formulir diupdate dan ada revisi menunggu, status revisi berubah menjadi "selesai"
    - Import RevisiPendaftaran dan DB

### 4. **Views**

- `resources/views/admin/verifikasi/show.blade.php` 🔄 **DIUPDATE**
    - Tambah button **"Minta Revisi"** (warna kuning)
    - Tambah modal untuk input field revisi dan catatan
    - Modal berisi checkbox field dan textarea untuk catatan

- `resources/views/formulir/index.blade.php` 🔄 **DIUPDATE**
    - Tambah alert warning jika ada revisi menunggu
    - Alert menampilkan:
        - Ikon warning (!)
        - Catatan dari admin
        - Daftar field yang perlu direvisi
    - Ubah label tombol submit: "Simpan Revisi" jika ada revisi
    - Update logika disable form: hanya disable jika sudah bayar DAN tidak ada revisi
    - Update script JavaScript untuk kondisi disable form yang baru

### 5. **Routes**

- `routes/web.php` 🔄 **DIUPDATE**
    - Tambah route POST: `/admin/verifikasi/{id}/revisi` → `VerifikasiController@mintaRevisi`
    - Route name: `admin.verifikasi.mintaRevisi`

---

## API Endpoints

### Admin - Minta Revisi

```
POST /admin/verifikasi/{id}/revisi
Content-Type: application/x-www-form-urlencoded

Parameters:
- field_revisi[] : array of field names (required, min 1 item)
- catatan_revisi : string (required, max 1000 chars)

Response:
- Redirect ke /admin/verifikasi dengan pesan success
```

### Validation Rules

```php
'field_revisi' => 'required|array|min:1',
'field_revisi.*' => 'string|in:nama_lengkap,nisn,jenis_kelamin,tempat_lahir,tanggal_lahir,asal_sekolah,agama,nik,anak_ke,alamat,desa,kelurahan,kecamatan,kota,no_hp,dokumen',
'catatan_revisi' => 'required|string|max:1000'
```

---

## Status Code dan Pesan

| Status     | Pesan                      | Kondisi                               |
| ---------- | -------------------------- | ------------------------------------- |
| 'menunggu' | Revisi menunggu dikerjakan | Revisi baru dibuat oleh admin         |
| 'selesai'  | Revisi sudah dikerjakan    | Calon siswa submit form dengan revisi |

---

## Alur Data di Database

```
1. Admin membuat revisi
   → INSERT into revisi_pendaftaran (formulir_id, admin_id, field_revisi, catatan_revisi, status_revisi='menunggu')

2. Calon siswa melihat revisi
   → SELECT * FROM revisi_pendaftaran WHERE formulir_id=? AND status_revisi='menunggu'

3. Calon siswa submit revisi
   → UPDATE formulir_pendaftaran SET data_baru
   → UPDATE revisi_pendaftaran SET status_revisi='selesai', selesai_at=NOW()

4. Admin verifikasi lagi
   → SELECT * FROM formulir_pendaftaran WHERE status_verifikasi='menunggu' (form dengan revisi selesai)
```

---

## Fitur Tambahan yang Bisa Dikembangkan

1. **Notifikasi Email**: Kirim email ke calon siswa ketika ada revisi baru
2. **History Revisi**: Tampilkan semua history revisi yang sudah dilakukan
3. **Deadline Revisi**: Tentukan deadline kapan calon siswa harus menyelesaikan revisi
4. **Admin Notes**: Tambah catatan per-field (bukan hanya catatan umum)
5. **Document Preview**: Admin bisa langsung preview dokumen sambil memberi revisi
6. **WhatsApp Notification**: Notifikasi ke nomor HP calon siswa

---

## Testing Checklist

- [ ] Admin bisa membuka modal revisi di halaman verifikasi
- [ ] Admin bisa memilih multiple field untuk revisi
- [ ] Admin bisa submit form revisi dengan catatan
- [ ] Data revisi tersimpan ke database dengan benar
- [ ] Calon siswa melihat alert revisi saat login form pendaftaran
- [ ] Alert menampilkan catatan dan daftar field yang benar
- [ ] Form menjadi editable meski sudah bayar saat ada revisi
- [ ] Tombol submit berubah jadi "Simpan Revisi" saat ada revisi
- [ ] Calon siswa bisa submit revisi dan data terupdate
- [ ] Status revisi berubah menjadi 'selesai' setelah calon siswa submit
- [ ] Calon siswa muncul di daftar verifikasi lagi setelah submit revisi
- [ ] Admin bisa verifikasi atau minta revisi lagi
- [ ] Alert revisi hilang setelah revisi selesai dan admin verifikasi

---

## Catatan Penting

1. **Form Lock**: Form pendaftaran tetap terkunci jika sudah bayar, kecuali ada revisi menunggu
2. **Multiple Revisions**: Sistem mendukung multiple rounds revisi (bisa revisi berkali-kali)
3. **Database Transactions**: Method store() menggunakan DB::transaction untuk konsistensi data
4. **Status Flow**:
    - Normal: `menunggu` → `diverifikasi`
    - Dengan Revisi: `menunggu` → `menunggu` (revisi dibuat) → `menunggu` (revisi selesai) → `diverifikasi`

---

**Created**: 2025-01-19  
**Last Updated**: 2025-01-19
