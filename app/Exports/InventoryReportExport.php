<?php

namespace App\Exports;

use App\Models\InventoryUsage;
use App\Models\InventoryPurchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }

    public function collection()
    {
        $startDate = $this->month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        return InventoryUsage::with(['inventoryItem', 'technician.user', 'booking'])
            ->whereBetween('used_at', [$startDate, $endDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Teknisi',
            'Booking ID',
            'Jumlah Digunakan',
            'Tanggal Penggunaan',
            'Catatan'
        ];
    }

    public function map($usage): array
    {
        return [
            $usage->inventoryItem->name,
            $usage->technician && $usage->technician->user ? $usage->technician->user->name : 'Data teknisi tidak ditemukan',
            $usage->booking_id,
            $usage->quantity_used,
            $usage->used_at->format('d/m/Y H:i'),
            $usage->notes
        ];
    }
}