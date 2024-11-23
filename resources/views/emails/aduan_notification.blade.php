<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Aduan Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
        }

        .content p {
            margin: 10px 0;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Aduan Baru Diterima</h1>
            <p>Notifikasi tentang laporan terbaru yang telah dikirimkan.</p>
        </div>
        <div class="content">
            <p><strong>Nama Pelapor:</strong> {{ $aduan['nama'] }}</p>
            <p><strong>Email Pelapor:</strong> {{ $aduan['email'] }}</p>
            <p><strong>Judul Aduan:</strong> {{ $aduan['judul'] }}</p>
            <p><strong>Keterangan Aduan:</strong></p>
            <p style="background-color: #f1f1f1; padding: 10px; border-radius: 5px;">{{ $aduan['keterangan'] }}</p>
            <p><strong>Tipe Aduan:</strong> {{ $aduan['type'] }}</p>
            @if ($aduan['type'] == 'Private')
                <p><strong>Token Rahasia:</strong> <span style="color: #dc3545;">{{ $aduan['token'] }}</span></p>
                <p>Gunakan token ini untuk melacak status aduan Anda.</p>
            @endif
        </div>
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami.</p>
        </div>
    </div>
</body>

</html>
