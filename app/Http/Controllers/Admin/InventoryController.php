<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryPurchase;
use App\Models\InventoryUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\InventoryReportExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::with(['purchases', 'usages'])->paginate(15);
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:Layak Pakai,Tidak Layak',
            'minimum_stock' => 'required|integer|min:0'
        ]);

        $item = InventoryItem::create($request->all());
        $item->updateStatus();

        // Jika ada stok awal, catat sebagai pembelian
        if ($request->stock_quantity > 0) {
            InventoryPurchase::create([
                'inventory_item_id' => $item->id,
                'admin_id' => Auth::id(),
                'quantity' => $request->stock_quantity,
                'unit_price' => $request->unit_price ?? 0,
                'total_price' => ($request->unit_price ?? 0) * $request->stock_quantity,
                'purchase_date' => now()->toDateString(),
                'notes' => 'Stok awal'
            ]);
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(InventoryItem $inventoryItem)
    {
        $inventoryItem->load(['purchases.admin', 'usages.technician', 'usages.booking']);
        return view('admin.inventory.show', compact('inventoryItem'));
    }

    public function edit(InventoryItem $inventoryItem)
    {
        return view('admin.inventory.edit', compact('inventoryItem'));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:Layak Pakai,Tidak Layak',
            'minimum_stock' => 'required|integer|min:0'
        ]);

        $inventoryItem->update($request->only([
            'name', 'description', 'unit_price', 'condition', 'minimum_stock'
        ]));

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Barang berhasil diperbarui');
    }

    public function restock(Request $request, InventoryItem $inventoryItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        // Tambah stok
        $inventoryItem->addStock($request->quantity);

        // Catat pembelian
        InventoryPurchase::create([
            'inventory_item_id' => $inventoryItem->id,
            'admin_id' => Auth::id(),
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $request->unit_price * $request->quantity,
            'purchase_date' => $request->purchase_date,
            'notes' => $request->notes
        ]);

        return redirect()->back()
            ->with('success', 'Stok berhasil ditambahkan');
    }

    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $startDate = $month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $usages = InventoryUsage::with(['inventoryItem', 'technician', 'booking'])
            ->whereBetween('used_at', [$startDate, $endDate])
            ->get()
            ->groupBy('inventory_item_id');

        $purchases = InventoryPurchase::with(['inventoryItem', 'admin'])
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->get()
            ->groupBy('inventory_item_id');

        return view('admin.inventory.monthly-report', compact('usages', 'purchases', 'month'));
    }

    public function exportReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return $this->exportPDF($month);
        }

        return Excel::download(new InventoryReportExport($month), "inventory-report-{$month}.xlsx");
    }

    private function exportPDF($month)
    {
        $startDate = $month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $usages = InventoryUsage::with(['inventoryItem', 'technician'])
            ->whereBetween('used_at', [$startDate, $endDate])
            ->get()
            ->groupBy('inventory_item_id');

        $purchases = InventoryPurchase::with(['inventoryItem'])
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->get()
            ->groupBy('inventory_item_id');

        $pdf = PDF::loadView('admin.inventory.report-pdf', compact('usages', 'purchases', 'month'));
        return $pdf->download("inventory-report-{$month}.pdf");
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        try {
            $inventoryItem->usages()->delete();
            
            $inventoryItem->purchases()->delete();
            
            $inventoryItem->delete();
    
            return redirect()->route('admin.inventory.index')
                ->with('success', 'Item inventory berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus item inventory. Silakan coba lagi.');
        }
    }
}