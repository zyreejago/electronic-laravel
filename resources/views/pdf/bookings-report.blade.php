<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        .date-range {
            font-size: 14px;
            color: #888;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-item {
            text-align: center;
            flex: 1;
        }
        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .summary-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            font-size: 10px;
        }
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 9px;
            text-transform: uppercase;
        }
        .status-completed { background-color: #28a745; }
        .status-pending { background-color: #ffc107; color: #333; }
        .status-confirmed { background-color: #17a2b8; }
        .status-in_progress { background-color: #fd7e14; }
        .status-cancelled { background-color: #dc3545; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Service Center</div>
        <div class="report-title">Laporan Booking</div>
        <div class="date-range">
            Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}
        </div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-value">{{ $totalBookings }}</div>
            <div class="summary-label">Total Booking</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $completedBookings }}</div>
            <div class="summary-label">Selesai</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="summary-label">Total Revenue</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Service</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>#{{ $booking->id }}</td>
                <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                <td>
                    {{ $booking->user->name }}<br>
                    <small>{{ $booking->user->phone_number }}</small>
                </td>
                <td>{{ $booking->service->name }}</td>
                <td>
                    @if($booking->technicians->count() > 0)
                        {{ $booking->technicians->pluck('user.name')->join(', ') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="status status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>