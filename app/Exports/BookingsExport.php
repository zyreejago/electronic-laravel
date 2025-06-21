<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::with(['user', 'service', 'technicians.user'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Booking',
            'Tanggal Masuk',
            'Nama Pelanggan',
            'No. HP',
            'Jenis Service',
            'Deskripsi',
            'Kerusakan',
            'Estimasi Biaya',
            'Teknisi',
            'Status',
            'Total Harga',
            'Tanggal Selesai'
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->created_at->format('d/m/Y H:i'),
            $booking->user->name,
            $booking->user->phone_number,
            $booking->service->name,
            $booking->description,
            $booking->damage_description ?? '-',
            $booking->estimated_cost ? 'Rp ' . number_format($booking->estimated_cost, 0, ',', '.') : '-',
            $booking->technicians->pluck('user.name')->join(', ') ?: '-',
            ucfirst($booking->status),
            'Rp ' . number_format($booking->total_price, 0, ',', '.'),
            $booking->status === 'completed' ? $booking->updated_at->format('d/m/Y H:i') : '-'
        ];
    }
}