<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tanda Terima Penerimaan Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border: 1px solid #ddd; }
        .signature-section { margin-top: 50px; }
        .signature-box { width: 200px; height: 80px; border: 1px solid #000; display: inline-block; margin: 10px; text-align: center; }
        .service-number { font-size: 18px; font-weight: bold; color: #007bff; }
    </style>
</head>
<body>
    <div class="header">
        <h2>TANDA TERIMA PENERIMAAN BARANG</h2>
        <p>Service Center Electronics</p>
        <div class="service-number">No. Service: {{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
    
    <table class="info-table">
        <tr>
            <td width="30%"><strong>Tanggal & Waktu Masuk</strong></td>
            <td>{{ $booking->created_at->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan</strong></td>
            <td>{{ $booking->user->name }}</td>
        </tr>
        <tr>
            <td><strong>No. HP</strong></td>
            <td>{{ $booking->user->phone_number ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Barang/Service</strong></td>
            <td>{{ $booking->service->name }}</td>
        </tr>
        <tr>
            <td><strong>Kategori Kerusakan</strong></td>
            <td>{{ ucwords(str_replace('_', ' ', $booking->damage_category)) }}</td>
        </tr>
        @if($booking->item_condition)
        <tr>
            <td><strong>Kondisi Fisik</strong></td>
            <td>{{ ucfirst($booking->item_condition) }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Keluhan</strong></td>
            <td>{{ $booking->description }}</td>
        </tr>
        @if($booking->accessories_included)
        <tr>
            <td><strong>Aksesoris Diserahkan</strong></td>
            <td>{{ $booking->accessories_included }}</td>
        </tr>
        @endif
    </table>
    
    <div class="signature-section">
        <table width="100%">
            <tr>
                <td width="50%" style="text-align: center;">
                    <p><strong>Penerima (Teknisi)</strong></p>
                    <div class="signature-box">
                        <br><br><br>
                        <p>(...........................)</p>
                    </div>
                    <p>Tanggal: {{ now()->format('d/m/Y') }}</p>
                </td>
                <td width="50%" style="text-align: center;">
                    <p><strong>Penyerah (Pelanggan)</strong></p>
                    <div class="signature-box">
                        <br><br><br>
                        <p>(...........................)</p>
                    </div>
                    <p>Tanggal: {{ now()->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
    </div>
    
    <div style="margin-top: 30px; font-size: 10px; text-align: center; color: #666;">
        <p>* Simpan tanda terima ini sebagai bukti penyerahan barang</p>
        <p>* Untuk informasi status perbaikan, hubungi kami dengan menyebutkan nomor service</p>
    </div>
</body>
</html>