# PPDB Online SMK Antartika 1 Sidoarjo

Aplikasi Penerimaan Peserta Didik Baru (PPDB) Online berbasis Laravel.

## 🚀 Panduan Instalasi (Untuk Developer/Clone)

Ikuti langkah-langkah berikut untuk menjalankan project ini di local environment Anda:

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

### Langkah Instalasi

1.  **Clone Repository**
    ```bash
    git clone <repository-url>
    cd jeks
    ```

2.  **Install Dependencies Backend**
    ```bash
    composer install
    ```

3.  **Setup Environment**
    - Copy file `.env.example` menjadi `.env`
    ```bash
    cp .env.example .env
    ```
    - Sesuaikan konfigurasi database di `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    - Sesuaikan konfigurasi Midtrans di `.env`:
    ```env
    MIDTRANS_SERVER_KEY=your-server-key
    MIDTRANS_CLIENT_KEY=your-client-key
    MIDTRANS_IS_PRODUCTION=false
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Setup Database & Seeding**
    ```bash
    php artisan migrate --seed
    ```
    *Note: Seeding akan mengisi data master seperti Jurusan, Gelombang, dan Kelas.*

6.  **Setup Storage Link**
    ```bash
    php artisan storage:link
    ```

7.  **Install Dependencies Frontend**
    ```bash
    npm install
    npm run build
    ```

8.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di `http://localhost:8000`.

---

## ✨ Fitur Utama

### 1. Pendaftaran Siswa Baru
- Calon siswa dapat mendaftar akun dan mengisi formulir pendaftaran secara online.
- Data yang diisi meliputi biodata diri, data orang tua/wali, dan upload dokumen.

### 2. Pembayaran & Promo (Midtrans Integration)
- **Pembayaran Online**: Terintegrasi dengan Midtrans Payment Gateway.
- **Biaya Dinamis**: Biaya pendaftaran otomatis diambil dari data Gelombang Pendaftaran yang aktif.
- **Promo Code**:
    - Calon siswa dapat memasukkan kode promo untuk mendapatkan potongan harga.
    - Validasi real-time via AJAX.
    - **Proteksi Data**: Promo yang sudah digunakan dalam transaksi tidak dapat diubah (kode/nominal) atau dihapus oleh admin.

### 3. Pembagian Kelas Otomatis (Auto-Assign Class)
- Sistem otomatis membagi kelas setelah pembayaran berstatus **LUNAS**.
- **Logika Pembagian**:
    - Mencari kelas yang sesuai dengan jurusan pilihan siswa.
    - Mengisi kelas secara berurutan (misal: X RPL 1 penuh -> lanjut ke X RPL 2).
    - **Auto-Create Class**: Jika semua kelas penuh, sistem otomatis membuat kelas baru (misal: X RPL 4) dan memasukkan siswa ke dalamnya.

### 4. Cetak Bukti Pendaftaran (PDF)
- Calon siswa dapat mengunduh **Bukti Pendaftaran** dalam format PDF.
- **Syarat Unduh**: Dokumen hanya bisa diunduh setelah status pendaftaran **DIVERIFIKASI** oleh admin.
- PDF berisi:
    - Data Pendaftaran (No. Daftar, Jurusan, Kelas).
    - Biodata Siswa.
    - Instruksi selanjutnya (pengambilan seragam, jadwal, dll).

### 5. Admin Panel
- Dashboard statistik pendaftaran.
- Manajemen Data Master (Jurusan, Gelombang, Kelas, Promo).
- Verifikasi Pendaftaran & Dokumen.
- Laporan Pembayaran.

---

## 🛠 Teknologi yang Digunakan
- **Backend**: Laravel 11
- **Frontend**: Blade, Tailwind CSS / Bootstrap
- **Database**: MySQL
- **Payment Gateway**: Midtrans
- **PDF Generator**: dompdf

---

## 📝 Catatan Pengembang
- Pastikan konfigurasi Midtrans di `.env` sudah benar agar fitur pembayaran berjalan lancar.
- Gunakan `php artisan db:seed` untuk mengisi data awal yang dibutuhkan sistem.
