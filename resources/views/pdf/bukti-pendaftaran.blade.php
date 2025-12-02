<!DOCTYPE html>
<html>

<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .content {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            width: 30%;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #666;
        }

        .info-box {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #312e81;
        }

        .payment-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }

        .status-lunas {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-menunggu {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-pending {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .payment-instruction {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 14px;
        }

        .payment-code {
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #1e40af;
            background-color: #f8fafc;
            padding: 8px;
            border: 1px dashed #cbd5e1;
            text-align: center;
            margin: 5px 0;
        }

        .amount-detail {
            margin-top: 10px;
            padding: 10px;
            background-color: #f9fafb;
            border-left: 4px solid #3b82f6;
        }

        .checkmark {
            color: #10b981;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>SMK ANTARTIKA 1 SIDAORJO</h1>
        <p>Jl. Raya Siwalanpanji, Buduran, Sidoarjo (031) 8962851</p>
        <p>Website: www.smkantartika1sidoarjo.sch.id | Email: smks.antartika1.sda@gmail.com</p>
    </div>

    <div class="content">
        <h2 style="text-align: center; text-decoration: underline;">BUKTI PENDAFTARAN SISWA BARU</h2>
        <p style="text-align: center;">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>

        <h3>A. Data Pendaftaran</h3>
        <table class="table">
            <tr>
                <th>Nomor Pendaftaran</th>
                <td>{{ $formulir->nomor_pendaftaran ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Daftar</th>
                <td>{{ $formulir->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td>{{ $formulir->jurusan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Gelombang</th>
                <td>{{ $formulir->gelombang->nama_gelombang ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td>{{ $formulir->kelas->nama_kelas ?? 'Belum ditentukan' }}</td>
            </tr>
        </table>

        <h3>B. Data Calon Siswa</h3>
        <table class="table">
            <tr>
                <th>NISN</th>
                <td>{{ $formulir->nisn }}</td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $formulir->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>{{ $formulir->tempat_lahir }}, {{ $formulir->tanggal_lahir->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $formulir->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Asal Sekolah</th>
                <td>{{ $formulir->asal_sekolah }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $formulir->alamat }}</td>
            </tr>
        </table>

        <!-- BAGIAN C: INFORMASI PEMBAYARAN -->
        <h3>C. Informasi Pembayaran</h3>
        <table class="table">
            <tr>
                <th>Status Pembayaran</th>
                <td>
                    @if($formulir->pembayaran)
                        @php
                            $status = $formulir->pembayaran->status;
                            $statusClass = 'status-menunggu';
                            
                            if ($status === 'Lunas') $statusClass = 'status-lunas';
                            elseif ($status === 'Pending') $statusClass = 'status-pending';
                            elseif ($status === 'Failed') $statusClass = 'status-failed';
                        @endphp
                        <span class="payment-status {{ $statusClass }}">{{ $status }}</span>
                    @else
                        <span class="payment-status status-menunggu">BELUM BAYAR</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Kode Transaksi</th>
                <td>
                    @if($formulir->pembayaran && $formulir->pembayaran->kode_transaksi)
                        <div class="payment-code">{{ $formulir->pembayaran->kode_transaksi }}</div>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @if($formulir->pembayaran)
           
            @endif
            <tr>
                <th>Total Biaya</th>
                <td>
                    @if($formulir->pembayaran && $formulir->pembayaran->jumlah_akhir)
                        <div class="amount-detail">
                            <strong>Rp {{ number_format($formulir->pembayaran->jumlah_akhir, 0, ',', '.') }}</strong>
                            @if($formulir->pembayaran->jumlah_awal != $formulir->pembayaran->jumlah_akhir)
                                <br>
                                <small>
                                    (Normal: Rp {{ number_format($formulir->pembayaran->jumlah_awal, 0, ',', '.') }})
                                    @if($formulir->pembayaran->promo_voucher_id)
                                        <br>[Menggunakan promo/voucher]
                                    @endif
                                </small>
                            @endif
                        </div>
                    @elseif($formulir->gelombang && $formulir->gelombang->harga)
                        <div class="amount-detail">
                            <strong>Rp {{ number_format($formulir->gelombang->harga, 0, ',', '.') }}</strong>
                            <br>
                            <small>Belum ada transaksi pembayaran</small>
                        </div>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @if($formulir->pembayaran)
            <tr>
                <th>Metode Pembayaran</th>
                <td>
                    {{ $formulir->pembayaran->metode_bayar ?? '-' }}
                    @if($formulir->pembayaran->midtrans_payment_type)
                        <br>
                        <small>({{ $formulir->pembayaran->midtrans_payment_type }})</small>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Tanggal Pembayaran</th>
                <td>
                    @if($formulir->pembayaran->tanggal_bayar)
                        {{ \Carbon\Carbon::parse($formulir->pembayaran->tanggal_bayar)->format('d F Y H:i:s') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Verifikasi Pembayaran</th>
                <td>
                    @if($formulir->pembayaran->verified_at || $formulir->pembayaran->status === 'Lunas')
                        <div>
                            <!-- <span class="checkmark">✓</span>  -->
                            Telah diverifikasi
                            @if($formulir->pembayaran->verified_at)
                                <br>
                                <small>Pada: {{ \Carbon\Carbon::parse($formulir->pembayaran->verified_at)->format('d F Y H:i') }}</small>
                            @elseif($formulir->pembayaran->tanggal_bayar)
                                <br>
                                <!-- <small>Verifikasi otomatis pada: {{ \Carbon\Carbon::parse($formulir->pembayaran->tanggal_bayar)->format('d F Y H:i') }}</small> -->
                            @endif
                            
                            @if($formulir->pembayaran->admin_verifikasi_id && $formulir->pembayaran->admin_verifikasi_id > 0)
                                @if($formulir->pembayaran->adminVerifikasi)
                                    <br>
                                    <small>Oleh: {{ $formulir->pembayaran->adminVerifikasi->name }}</small>
                                @endif
                            @else
                                <!-- <br>
                                <small>Oleh: Sistem otomatis</small> -->
                            @endif
                        </div>
                    @else
                        Belum diverifikasi
                    @endif
                </td>
            </tr>
            @if($formulir->pembayaran->catatan)
            <tr>
                <th>Catatan</th>
                <td>{{ $formulir->pembayaran->catatan }}</td>
            </tr>
            @endif
            @endif
        </table>

        @if(!$formulir->pembayaran || !$formulir->pembayaran->isPaid())
        <div class="payment-instruction">
            <h4 style="margin-top: 0; color: #92400e;">Instruksi Pembayaran:</h4>
            <ol>
                <li>Silakan lakukan pembayaran melalui menu <strong>Pembayaran</strong> di akun Anda</li>
                <li>Pilih metode pembayaran yang tersedia:
                    <ul>
                        <li>Transfer Bank (BCA, BNI, BRI, Mandiri, dll)</li>
                        <li>Virtual Account (VA)</li>
                        <li>E-Wallet (Gopay, Shopeepay, dll)</li>
                        <li>QRIS</li>
                        <li>Convenience Store (Alfamart, Indomaret)</li>
                    </ul>
                </li>
                <li>Pembayaran akan diverifikasi otomatis oleh sistem dalam 1x24 jam</li>
                <li>Simpan bukti transaksi Anda</li>
                <li>Pendaftaran hanya sah setelah pembayaran berstatus <strong>LUNAS</strong></li>
            </ol>
            @if($formulir->pembayaran && $formulir->pembayaran->kode_transaksi)
                <p><strong>Kode Transaksi Anda:</strong> {{ $formulir->pembayaran->kode_transaksi }}</p>
            @endif
            <p><strong>Hubungi kami jika ada kendala:</strong> (031) 8962851</p>
        </div>
        @endif

        <div class="info-box">
            <h3>Informasi Penting</h3>
            <p>Silakan bawa bukti pendaftaran ini ke sekolah untuk:</p>
            <ul>
                <li>Pengambilan seragam sekolah (setelah pembayaran LUNAS).</li>
                <li>Verifikasi berkas fisik (jika diperlukan).</li>
                <li>Informasi pembagian jadwal pelajaran.</li>
                <li>Proses administrasi selanjutnya.</li>
            </ul>
            <p><strong>Catatan:</strong> 
                @if($formulir->pembayaran && $formulir->pembayaran->isPaid())
                    [Pembayaran Anda telah LUNAS. Simpan dokumen ini sebagai bukti sah pendaftaran.]
                @else
                    Harap selesaikan pembayaran terlebih dahulu untuk melengkapi proses pendaftaran.
                @endif
            </p>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        @if($formulir->pembayaran)
            <p>ID Transaksi: {{ $formulir->pembayaran->kode_transaksi ?? '-' }}</p>
        @endif
    </div>
</body>

</html>