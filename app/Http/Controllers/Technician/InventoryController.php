<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryUsage;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::where('status', 'Tersedia')
            ->where('condition', 'Layak Pakai')
            ->orderBy('name')
            ->get();

        return view('technician.inventory.index', compact('items'));
    }

    public function useItem(Request $request)
    {
        $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'booking_id' => 'required|exists:bookings,id',
            'quantity_used' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        // Pastikan user adalah technician dan memiliki data technician
        $user = Auth::user();
        if (!$user || $user->role !== 'technician') {
            return redirect()->back()
                ->with('error', 'Akses ditolak. Hanya teknisi yang dapat menggunakan fitur ini.');
        }

        if (!$user->technician) {
            return redirect()->back()
                ->with('error', 'Data teknisi tidak ditemukan. Silakan hubungi administrator.');
        }

        $item = InventoryItem::findOrFail($request->inventory_item_id);
        $booking = Booking::findOrFail($request->booking_id);

        // Cek apakah stok mencukupi
        if ($item->stock_quantity < $request->quantity_used) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $item->stock_quantity);
        }

        // Kurangi stok
        $item->reduceStock($request->quantity_used);

        // Catat penggunaan
        InventoryUsage::create([
            'inventory_item_id' => $item->id,
            'technician_id' => $user->technician->id,
            'booking_id' => $booking->id,
            'quantity_used' => $request->quantity_used,
            'used_at' => now(),
            'notes' => $request->notes
        ]);

        return redirect()->back()
            ->with('success', 'Barang berhasil digunakan. Stok tersisa: ' . $item->stock_quantity);
    }
}