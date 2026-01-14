<!DOCTYPE html>
<html>

<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            margin: 0;
            padding: 10px;
            font-size: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1.5px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
            position: relative;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0 0;
            font-size: 9px;
        }

        .content {
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 9px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            width: 30%;
        }

        .footer {
            margin-top: 20px;
            font-size: 8px;
            text-align: center;
            color: #666;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .info-box {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 10px;
            border-radius: 3px;
            margin-top: 15px;
            font-size: 9px;
        }

        .payment-status {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 9px;
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

        /* Styling untuk logo */
        .logo-container {
            position: absolute;
            top: 5px;
            right: 10px;
            text-align: center;
        }

        .logo {
            width: 45px;
            height: auto;
        }

        /* Styling untuk tanda tangan digital */
        .signature-section {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 15px;
        }

        .qrcode-section {
            text-align: center;
            width: 150px;
        }

        .qrcode {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            padding: 3px;
            background-color: white;
            margin-bottom: 5px;
        }

        .signature-info {
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .official-signature {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            margin-top: 40px;
            border-bottom: 1px solid #000;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

        .official-name {
            margin-top: 3px;
            font-weight: bold;
            font-size: 9px;
        }

        .official-position {
            font-size: 8px;
            color: #666;
        }

        .stamp {
            position: absolute;
            opacity: 0.1;
            font-size: 60px;
            color: #ff0000;
            transform: rotate(-45deg);
            font-weight: bold;
        }

        .validation-info {
            font-size: 7px;
            color: #999;
            text-align: center;
            margin-top: 5px;
            font-style: italic;
        }

        h2 {
            text-align: center;
            text-decoration: underline;
            font-size: 14px;
            margin: 8px 0;
        }

        h3 {
            font-size: 11px;
            margin: 10px 0 8px 0;
            background-color: #f5f5f5;
            padding: 4px;
            border-left: 3px solid #1e40af;
        }

        p {
            margin: 3px 0;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>SMK ANTARTIKA 1 SIDAORJO</h1>
        <p>Jl. Raya Siwalanpanji, Buduran, Sidoarjo (031) 8962851</p>
        <p>Website: www.smkantartika1sidoarjo.sch.id | Email: smks.antartika1.sda@gmail.com</p>
        
        <!-- Logo sekolah -->
        <div class="logo-container">
            @if(file_exists(public_path('images/logo1-removebg-preview.png')))
                <img src="{{ public_path('images/logo1-removebg-preview.png') }}" alt="Logo SMK Antartika 1" class="logo">
            @else
                <!-- Fallback jika logo tidak ada -->
                <div style="width: 45px; height: 45px; background-color: #f0f0f0; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 7px; text-align: center;">LOGO<br>SMK</span>
                </div>
            @endif
        </div>
    </div>

    <div class="content">
        <h2>BUKTI PENDAFTARAN SISWA BARU</h2>
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
                        <div style="font-family: monospace; font-weight: bold; color: #1e40af; font-size: 9px;">{{ $formulir->pembayaran->kode_transaksi }}</div>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td>
                    @if($formulir->pembayaran && $formulir->pembayaran->jumlah_akhir)
                        <strong>Rp {{ number_format($formulir->pembayaran->jumlah_akhir, 0, ',', '.') }}</strong>
                    @elseif($formulir->gelombang && $formulir->gelombang->harga)
                        <strong>Rp {{ number_format($formulir->gelombang->harga, 0, ',', '.') }}</strong>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

       <!-- BAGIAN D: TANDA TANGAN DIGITAL -->
<div class="signature-section">
    <h3>QR</h3>
    
    <div class="signature-container">
        <!-- QR Code Section -->
        <div class="qrcode-section">
            @if(isset($qrCodeImage) && !empty($qrCodeImage))
                <img src="{{ $qrCodeImage }}" alt="QR Code Validasi" class="qrcode">
            @else
                <!-- Fallback jika QR Code tidak tersedia -->
                <div style="width: 80px; height: 80px; background-color: #f0f0f0; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px;">
                    <!-- <div style="text-align: center; font-size: 7px;">
                        [QR CODE]<br>
                        Scan untuk<br>
                        verifikasi
                    </div> -->
                </div>
            @endif
            <!-- <div class="signature-info">
                <strong>SCAN QR CODE</strong><br>
                Untuk verifikasi data siswa
            </div> -->
        </div>

        <!-- Official Signature Section (dikomentari)
        <div class="official-signature">
            <div class="signature-line"></div>
            <div class="official-name">Dr. H. Bambang Sutrisno, M.Pd.</div>
            <div class="official-position">Kepala Sekolah SMK Antartika 1 Sidoarjo</div>
            <div class="stamp">RESMI</div>
            <div class="validation-info">
                Dokumen ini sah secara digital<br>
                ID: {{ $formulir->id }} | Tanggal: {{ now()->format('d-m-Y') }}
            </div>
        </div> -->
    </div>
    
    <!-- <div style="text-align: center; margin-top: 15px; font-size: 9px; color: #666;">
        <strong>Petunjuk:</strong> Scan QR Code di atas untuk melihat data lengkap siswa di website sekolah.
    </div> -->
</div>
</div>
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Dokumen ID: {{ $formulir->nomor_pendaftaran }} | Halaman: 1/1</p>
    </div>
</body>

</html>