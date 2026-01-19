<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - {{ $formulir->nomor_pendaftaran ?? 'PPDB' }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        /* Header Table Layout */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #1e40af;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 5px;
        }

        .header-logo {
            width: 70px;
            text-align: center;
        }

        .header-logo img {
            width: 55px;
            height: auto;
        }

        .header-info {
            text-align: center;
        }

        .header-qr {
            width: 80px;
            text-align: center;
        }

        .header-qr img {
            width: 65px;
            height: 65px;
        }

        .school-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 3px;
        }

        .school-address {
            font-size: 9px;
            color: #555;
            line-height: 1.3;
        }

        .qr-label {
            font-size: 7px;
            color: #666;
            margin-top: 2px;
        }

        /* Document Title */
        .document-title {
            text-align: center;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .document-title h2 {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin: 0 0 3px 0;
            letter-spacing: 1px;
        }

        .document-title p {
            font-size: 10px;
            color: #666;
            margin: 0;
        }

        /* Registration Number */
        .registration-number {
            text-align: center;
            margin: 10px 0 15px;
        }

        .reg-number-box {
            display: inline-block;
            background: #1e40af;
            color: white;
            padding: 8px 25px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Section Title */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            background: #1e40af;
            color: white;
            padding: 5px 10px;
            margin-bottom: 0;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 12px;
        }

        .data-table td {
            padding: 6px 8px !important;
            border: 1px solid #ddd;
        }

        .data-table .label {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
            width: 25%;
        }

        .data-table .value {
            color: #1f2937;
        }

        /* Two Column Layout */
        .two-column-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .two-column-table td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .two-column-table td:first-child {
            padding-right: 6px;
        }

        .two-column-table td:last-child {
            padding-left: 6px;
        }

        .two-column-table .data-table {
            margin-bottom: 0;
        }

        /* Status Badge */
        .status-badge {
            padding: 3px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }

        .status-lunas {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .status-belum {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        /* Info Box */
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid #3b82f6;
            padding: 10px;
            margin: 15px 0;
            font-size: 9px;
        }

        .info-box strong {
            color: #1e40af;
        }

        /* Signature Section */
        .signature-table {
            width: 100%;
            margin-top: 20px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }

        .signature-line {
            margin-top: 50px;
            border-bottom: 1px solid #333;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-name {
            margin-top: 5px;
            font-weight: bold;
            font-size: 10px;
        }

        .signature-position {
            font-size: 9px;
            color: #666;
        }

        .signature-date {
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .verification-note {
            margin-top: 8px;
            font-style: italic;
            font-size: 8px;
            color: #888;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                @if(file_exists(public_path('images/logo1-removebg-preview.png')))
                <img src="{{ public_path('images/logo1-removebg-preview.png') }}" alt="Logo">
                @else
                <div style="width: 55px; height: 55px; background: #f0f0f0; border: 1px solid #ddd;"></div>
                @endif
            </td>
            <td class="header-info">
                <div class="school-name">SMK ANTARTIKA 1 SIDOARJO</div>
                <div class="school-address">
                    Jl. Raya Siwalanpanji, Buduran, Sidoarjo 61252<br>
                    Telp: (031) 8962851 | Email: smks.antartika1.sda@gmail.com<br>
                    Website: www.smkantartika1sidoarjo.sch.id
                </div>
            </td>
            <td class="header-qr">
                @if(isset($qrCodeImage) && !empty($qrCodeImage))
                <img src="{{ $qrCodeImage }}" alt="QR Code">
                <div class="qr-label">Scan untuk verifikasi</div>
                @else
                <div style="width: 65px; height: 65px; background: #f5f5f5; border: 1px solid #ddd;"></div>
                @endif
            </td>
        </tr>
    </table>

    <!-- Document Title -->
    <div class="document-title">
        <h2>BUKTI PENDAFTARAN SISWA BARU</h2>
        <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <!-- Registration Number -->
    <div class="registration-number">
        <span class="reg-number-box">{{ $formulir->nomor_pendaftaran ?? 'PENDING' }}</span>
    </div>

    <!-- Two Column: Data Pendaftaran & Pembayaran -->
    <table class="two-column-table">
        <tr>
            <td>
                <div class="section-title">A. DATA PENDAFTARAN</div>
                <table class="data-table">
                    <tr>
                        <td class="label">Tanggal Daftar</td>
                        <td class="value">{{ $formulir->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jurusan</td>
                        <td class="value">{{ $formulir->jurusan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Gelombang</td>
                        <td class="value">{{ $formulir->gelombang->nama_gelombang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td class="value">{{ $formulir->kelas->nama_kelas ?? 'Belum ditentukan' }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <div class="section-title">B. INFORMASI PEMBAYARAN</div>
                <table class="data-table">
                    <tr>
                        <td class="label">Status</td>
                        <td class="value">
                            @if($formulir->pembayaran && $formulir->pembayaran->status === 'Lunas')
                            <span class="status-badge status-lunas">LUNAS</span>
                            @elseif($formulir->pembayaran && $formulir->pembayaran->status === 'Pending')
                            <span class="status-badge status-pending">PENDING</span>
                            @else
                            <span class="status-badge status-belum">BELUM BAYAR</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Kode Transaksi</td>
                        <td class="value" style="font-family: monospace; font-size: 9px;">
                            {{ $formulir->pembayaran->kode_transaksi ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Total Biaya</td>
                        <td class="value" style="font-weight: bold;">
                            @if($formulir->pembayaran && $formulir->pembayaran->jumlah_akhir)
                            Rp {{ number_format($formulir->pembayaran->jumlah_akhir, 0, ',', '.') }}
                            @elseif($formulir->gelombang && $formulir->gelombang->harga)
                            Rp {{ number_format($formulir->gelombang->harga, 0, ',', '.') }}
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Bayar</td>
                        <td class="value">
                            {{ $formulir->pembayaran->tanggal_bayar?->format('d F Y') ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Data Calon Siswa -->
    <div class="section-title" style="margin-top: 12px;">C. DATA CALON SISWA</div>
    <table class="data-table">
        <tr>
            <td class="label" style="width: 15%;">NISN</td>
            <td class="value" style="width: 35%;">{{ $formulir->nisn ?? '-' }}</td>
            <td class="label" style="width: 15%;">NIK</td>
            <td class="value" style="width: 35%;">{{ $formulir->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="value" colspan="3" style="font-weight: bold; text-transform: uppercase;">{{ $formulir->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">TTL</td>
            <td class="value">{{ $formulir->tempat_lahir }}, {{ $formulir->tanggal_lahir->format('d-m-Y') }}</td>
            <td class="label">Jenis Kelamin</td>
            <td class="value">{{ $formulir->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="value">{{ $formulir->agama ?? '-' }}</td>
            <td class="label">Asal Sekolah</td>
            <td class="value">{{ $formulir->asal_sekolah }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="value" colspan="3">{{ $formulir->alamat }}, {{ $formulir->desa }}, {{ $formulir->kelurahan }}, {{ $formulir->kecamatan }}, {{ $formulir->kota }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td class="value" colspan="3">{{ $formulir->no_hp ?? '-' }}</td>
        </tr>
    </table>

    <!-- Info Box -->
    <div class="info-box">
        <strong>Catatan Penting:</strong><br>
        1. Simpan bukti pendaftaran ini dengan baik sebagai tanda bukti yang sah.<br>
        2. Scan QR Code untuk verifikasi keaslian dokumen melalui website resmi sekolah.<br>
        3. Dokumen ini berlaku sebagai bukti telah terdaftar sebagai calon siswa baru.
    </div>

    <!-- Signature -->
    <table class="signature-table">
        <tr>
            <td>
                <p style="font-size: 9px; margin-bottom: 5px;">Orang Tua/Wali,</p>
                <div class="signature-line"></div>
                <div class="signature-name">(...............................)</div>
            </td>
            <td>
                <p class="signature-date">Sidoarjo, {{ now()->format('d F Y') }}</p>
                <p style="font-size: 9px; margin-bottom: 5px;">Panitia PPDB,</p>
                <div class="signature-line"></div>
                <div class="signature-name">(_______________________)</div>
                <div class="signature-position">SMK Antartika 1 Sidoarjo</div>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB</p>
        <p>Dokumen ID: {{ $formulir->nomor_pendaftaran }} | Ref: {{ $formulir->id }}</p>
        <p class="verification-note">
            Dokumen ini dihasilkan secara otomatis oleh sistem PPDB Online SMK Antartika 1 Sidoarjo.
        </p>
    </div>
</body>

</html>