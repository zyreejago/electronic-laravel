<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventori Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .period {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #333;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN INVENTORI BULANAN</h2>
        <p>Sistem Manajemen Inventori</p>
    </div>

    <div class="period">
        Periode: {{ date('F Y', strtotime($month . '-01')) }}
    </div>

    @if($usages->count() > 0)
        <div class="section-title">PENGGUNAAN BARANG OLEH TEKNISI</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Teknisi</th>
                    <th>Jumlah Digunakan</th>
                    <th>Tanggal Penggunaan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usages as $itemId => $itemUsages)
                    @foreach($itemUsages as $usage)
                        <tr>
                            <td>{{ $usage->inventoryItem->name }}</td>
                            <td>
                                @if($usage->technician && $usage->technician->user)
                                    {{ $usage->technician->user->name }}
                                @else
                                    Data teknisi tidak ditemukan
                                @endif
                            </td>
                            <td>{{ $usage->quantity_used }}</td>
                            <td>{{ date('d/m/Y', strtotime($usage->used_at)) }}</td>
                            <td>{{ $usage->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">PENGGUNAAN BARANG OLEH TEKNISI</div>
        <p class="no-data">Tidak ada data penggunaan barang pada periode ini.</p>
    @endif

    @if($purchases->count() > 0)
        <div class="section-title">PEMBELIAN/RESTOK BARANG</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah Dibeli</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $itemId => $itemPurchases)
                    @foreach($itemPurchases as $purchase)
                        <tr>
                            <td>{{ $purchase->inventoryItem->name }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>Rp {{ number_format($purchase->unit_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                            <td>{{ date('d/m/Y', strtotime($purchase->purchase_date)) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right;">
            <strong>Total Pembelian: Rp {{ number_format($purchases->flatten()->sum('total_price'), 0, ',', '.') }}</strong>
        </div>
    @else
        <div class="section-title">PEMBELIAN/RESTOK BARANG</div>
        <p class="no-data">Tidak ada data pembelian barang pada periode ini.</p>
    @endif

    <div style="margin-top: 40px; text-align: right; font-size: 10px; color: #666;">
        <p>Laporan dibuat pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>