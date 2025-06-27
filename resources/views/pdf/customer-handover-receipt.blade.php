<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Serah Terima Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border: 1px solid #ddd; }
        .signature-section { margin-top: 50px; }
        .signature-box { width: 200px; height: 80px; border: 1px solid #000; display: inline-block; margin: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>TANDA TERIMA SERAH TERIMA BARANG</h2>
        <p>Service Center</p>
    </div>
    
    <table class="info-table">
        <tr>
            <td width="30%"><strong>No. Service</strong></td>
            <td>{{ $booking->id }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Masuk</strong></td>
            <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan</strong></td>
            <td>{{ $booking->user->name }}</td>
        </tr>
        <tr>
            <td><strong>No. HP</strong></td>
            <td>{{ $booking->user->phone_number }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Service</strong></td>
            <td>{{ $booking->service->name }}</td>
        </tr>
        <tr>
            <td><strong>Deskripsi</strong></td>
            <td>{{ $booking->description }}</td>
        </tr>
        @if($booking->damage_description)
        <tr>
            <td><strong>Kerusakan</strong></td>
            <td>{{ $booking->damage_description }}</td>
        </tr>
        @endif
        @if($booking->estimated_cost)
        <tr>
            <td><strong>Estimasi Biaya</strong></td>
            <td>Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</td>
        </tr>
        @endif
        @if($booking->estimated_duration_hours)
        <tr>
            <td><strong>Estimasi Waktu</strong></td>
            <td>{{ $booking->estimated_duration_hours }} jam</td>
        </tr>
        @endif
    </table>
    
    <div class="signature-section">
        <table width="100%">
            <tr>
                <td width="50%" style="text-align: center;">
                    <p>Pelanggan</p>
                    <div class="signature-box"></div>
                    <p>{{ $booking->user->name }}</p>
                </td>
                <td width="50%" style="text-align: center;">
                    <p>Petugas</p>
                    <div class="signature-box"></div>
                    <p>Admin</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>