<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Peserta</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        .card {
            width: 100%;
            border: 2px solid #111;
            padding: 25px;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #111;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 5px 0 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .photo-box {
            width: 110px;
            height: 140px;
            border: 1px solid #111;
            text-align: center;
            line-height: 140px;
            float: right;
            margin-left: 20px;
        }

        table {
            width: 75%;
            border-collapse: collapse;
        }

        td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            width: 160px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .signature {
            margin-top: 60px;
        }

        .note {
            margin-top: 30px;
            font-size: 11px;
            border-top: 1px solid #111;
            padding-top: 10px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>Kartu Peserta Seleksi Paskibraka</h2>
            <h3>Sistem Manajemen dan Pendaftaran Paskibraka</h3>
        </div>

        <div class="photo-box">
            Foto
        </div>

        <table>
            <tr>
                <td class="label">Nomor Peserta</td>
                <td>: PSK-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>: {{ $user->nik }}</td>
            </tr>
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>: {{ $biodata->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="label">Asal Sekolah</td>
                <td>: {{ $biodata->asal_sekolah }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td>: {{ $biodata->tempat_lahir }}, {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tinggi Badan</td>
                <td>: {{ $biodata->tinggi_badan }} cm</td>
            </tr>
            <tr>
                <td class="label">Berat Badan</td>
                <td>: {{ $biodata->berat_badan }} kg</td>
            </tr>
            <tr>
                <td class="label">Golongan Darah</td>
                <td>: {{ $biodata->golongan_darah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Verifikasi</td>
                <td>: Lulus Verifikasi</td>
            </tr>
        </table>

        <div class="clear"></div>

        <div class="footer">
            <p>Makassar, {{ date('d-m-Y') }}</p>
            <p>Panitia Seleksi Paskibraka</p>
            <div class="signature">
                <strong>Admin Seleksi</strong>
            </div>
        </div>

        <div class="note">
            <strong>Catatan:</strong>
            Kartu peserta ini wajib dibawa saat mengikuti tahapan seleksi. Peserta juga wajib membawa dokumen asli sesuai persyaratan yang telah diunggah pada aplikasi.
        </div>
    </div>
</body>
</html>
