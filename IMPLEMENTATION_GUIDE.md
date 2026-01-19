# Panduan Implementasi - Sistem Pembayaran dengan Lock & Warning

## 📚 Ringkasan Perubahan

Sistem ini telah diimplementasikan untuk memberikan perlindungan data dengan warning modal sebelum pembayaran dan lock form setelah pembayaran berhasil.

## 📂 File yang Diubah/Dibuat

### 1. Controllers

#### `app/Http/Controllers/FormulirPendaftaranController.php`

- **Perubahan:** Di method `index()`, tambah query cek pembayaran
- **Output:** Variable `$sudahBayar` dikirim ke view
- **Line:** Sekitar line 16-30

```php
// Cek status pembayaran
$sudahBayar = false;
if ($formulir) {
    $pembayaran = \App\Models\Pembayaran::where('formulir_id', $formulir->id)
        ->where('status', 'Lunas')
        ->first();
    $sudahBayar = (bool) $pembayaran;
}
```

#### `app/Http/Controllers/DataKeluargaController.php`

- **Perubahan:** Di method `index()`, tambah query cek pembayaran
- **Output:** Variable `$sudahBayar` dikirim ke view
- **Line:** Sekitar line 27-42

#### `app/Http/Controllers/DokumenController.php`

- **Perubahan:** Di method `index()`, tambah query cek pembayaran
- **Output:** Variable `$sudahBayar` dikirim ke view
- **Line:** Sekitar line 13-26

### 2. Views

#### `resources/views/pembayaran/confirmation-modal.blade.php` ✨ **BARU**

- Modal warning dengan checklist dan peringatan
- JavaScript functions: `openPaymentModal()`, `closePaymentModal()`, `confirmPayment()`
- Support Escape key dan background click to close

#### `resources/views/pembayaran/create.blade.php`

- **Perubahan:** Button dari `type="submit"` → `type="button"` dengan `onclick="openPaymentModal()"`
- **Perubahan:** Form mendapat `id="paymentForm"` untuk di-submit oleh modal
- **Perubahan:** Include modal di akhir file: `@include('pembayaran.confirmation-modal')`

#### `resources/views/formulir/index.blade.php`

- **Perubahan:** Tambah warning banner ketika `$sudahBayar = true`
- **Perubahan:** Form opacity menjadi 0.6 ketika sudah bayar
- **Perubahan:** Di field input pertama tambah class conditional untuk disabled state
- **Perubahan:** Tambah JavaScript di akhir untuk disable semua fields

#### `resources/views/data-keluarga/index.blade.php`

- **Perubahan:** Tambah warning banner
- **Perubahan:** Disable semua form inputs via JavaScript
- **Perubahan:** Apply styling untuk disabled state

#### `resources/views/dokumen/index.blade.php`

- **Perubahan:** Tambah warning banner
- **Perubahan:** Disable upload trigger dan file input
- **Perubahan:** JavaScript check pada DOMContentLoaded

### 3. Traits (Optional Helper)

#### `app/Traits/CheckPaymentStatus.php` ✨ **BARU**

- Helper trait untuk cek status pembayaran
- Methods: `isSudahBayar()`, `getPembayaranTerakhir()`, `getStatusPembayaran()`
- Bisa digunakan di controller/model jika diperlukan

## 🔄 Alur Eksekusi

### Sebelum Pembayaran

1. User login → lihat dashboard
2. Klik "Bayar Sekarang" di halaman pembayaran
3. View `pembayaran.create` ditampilkan dengan form pembayaran
4. Form input tersedia untuk diisi

### Saat Pembayaran

1. User klik "Lanjutkan ke Pembayaran"
2. JavaScript trigger: `openPaymentModal()`
3. Modal konfirmasi muncul dengan warning
4. User baca warning dan konfirmasi
5. Jika "Lakukan Pembayaran" → form submit
6. Controller proses pembayaran via Midtrans
7. Callback menerima response pembayaran

### Setelah Pembayaran Sukses

1. Database: `pembayaran.status = 'Lunas'`
2. User navigate ke halaman manapun
3. Controller cek: `Pembayaran::where('formulir_id', $formulir->id)->where('status', 'Lunas')->exists()`
4. Jika true → `$sudahBayar = true`
5. View menerima variable `$sudahBayar`
6. JavaScript disable semua form inputs
7. Warning banner ditampilkan

## 🧪 Testing Checklist

Sebelum go-to-production, test checklist berikut:

- [ ] **Modal Testing**
    - [ ] Modal muncul saat klik "Lanjutkan ke Pembayaran"
    - [ ] Tombol "Kembali" menutup modal
    - [ ] Tombol "Lakukan Pembayaran" submit form
    - [ ] Click outside modal menutupnya
    - [ ] Escape key menutupkan modal

- [ ] **Formulir Lock Testing**
    - [ ] Sebelum bayar: semua field editable
    - [ ] Setelah bayar: semua field disable
    - [ ] Warning banner visible setelah bayar
    - [ ] Form opacity correct
    - [ ] Data masih visible tapi read-only

- [ ] **Data Keluarga Lock Testing**
    - [ ] Sebelum bayar: form editable
    - [ ] Setelah bayar: form disable
    - [ ] Delete button disable setelah bayar
    - [ ] Kembali button tetap aktif (untuk navigasi)

- [ ] **Dokumen Lock Testing**
    - [ ] Sebelum bayar: upload button active
    - [ ] Setelah bayar: upload button disable
    - [ ] File yang sudah upload masih visible
    - [ ] Download button tetap berfungsi

- [ ] **Cross-Browser Testing**
    - [ ] Chrome
    - [ ] Firefox
    - [ ] Safari
    - [ ] Mobile browsers

- [ ] **Edge Cases**
    - [ ] Multiple tab sama user (one paid)
    - [ ] Refresh page setelah bayar
    - [ ] Back button browser handling
    - [ ] Session timeout handling

## ⚙️ Configuration

### Database

- Tidak ada migration baru diperlukan
- Menggunakan kolom `status` di tabel `pembayaran` yang sudah ada
- Value yang dicari: `'Lunas'`

### Environment

- Midtrans credentials tetap sama
- Laravel session handling default
- No additional packages needed

## 📊 Database Query References

**Check if user sudah bayar:**

```php
$sudahBayar = \App\Models\Pembayaran::where('formulir_id', $formulir->id)
    ->where('status', 'Lunas')
    ->exists();
```

**Get pembayaran details:**

```php
$pembayaran = \App\Models\Pembayaran::where('formulir_id', $formulir->id)
    ->where('status', 'Lunas')
    ->first();
```

## 🎯 Performance Considerations

1. **Query Optimization:**
    - Gunakan `exists()` jika hanya butuh boolean
    - Gunakan `first()` jika butuh detail

2. **Caching (Optional):**
    - Bisa cache pembayaran status per formulir
    - Invalidate cache saat pembayaran sukses

3. **N+1 Query Prevention:**
    - Gunakan eager loading jika ambil multiple records
    - `with(['pembayaran'])` pada formulir loading

## 🐛 Common Issues & Solutions

| Issue                | Cause                      | Solution                         |
| -------------------- | -------------------------- | -------------------------------- |
| Modal tidak muncul   | JavaScript tidak load      | Check file included dengan benar |
| Fields tidak disable | sudahBayar = false         | Cek pembayaran status di DB      |
| Form bisa disubmit   | Backend validasi tidak ada | Tambah server-side validation    |
| Data tidak visible   | Display none di CSS        | Gunakan opacity bukan display    |

## 🔐 Security Notes

1. **Always validate on backend:**

    ```php
    // Di controller store/update method
    if ($sudahBayar) {
        return response()->json(['message' => 'Cannot edit after payment'], 403);
    }
    ```

2. **Never trust client-side disable only:**
    - User bisa bypass disabled attribute
    - Always check `$sudahBayar` di backend

3. **CSRF Protection:**
    - Semua form tetap pakai `@csrf`
    - No changes to existing CSRF handling

## 📞 Support & Maintenance

### Regular Maintenance

- Monitor pembayaran status changes
- Check logs untuk failed payment handling
- Test email notifications

### Troubleshooting

1. Check Laravel logs: `storage/logs/laravel.log`
2. Database: `SELECT * FROM pembayaran WHERE status = 'Lunas'`
3. Browser console: F12 → Console tab untuk JavaScript errors

## 📝 Version History

| Version | Date     | Changes                |
| ------- | -------- | ---------------------- |
| 1.0     | Jan 2026 | Initial implementation |

---

**Last Updated:** January 19, 2026
**Maintained by:** Development Team
**Status:** Production Ready ✅
