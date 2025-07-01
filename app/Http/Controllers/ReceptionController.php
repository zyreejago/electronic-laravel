<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceptionController extends Controller
{
    public function create()
    {
        $services = Service::where('is_available', true)->get();
        $customers = User::where('role', 'user')->get();
        
        $damageCategories = [
            'tidak_hidup' => 'Tidak Hidup',
            'layar_rusak' => 'Layar Rusak/Pecah',
            'baterai_rusak' => 'Baterai Rusak',
            'charging_bermasalah' => 'Charging Bermasalah',
            'speaker_rusak' => 'Speaker/Audio Rusak',
            'kamera_rusak' => 'Kamera Rusak',
            'tombol_rusak' => 'Tombol Rusak',
            'software_error' => 'Software Error',
            'lainnya' => 'Lainnya'
        ];
        
        return view('admin.reception.create', compact('services', 'customers', 'damageCategories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'description' => 'required|string',
            'damage_category' => 'required|string',
            'item_condition' => 'nullable|string',
            'accessories_included' => 'nullable|string',
            'custom_damage_category_input' => 'nullable|string',
            'custom_item_condition_input' => 'nullable|string',
        ]);
        
        // Handle custom inputs
        $damageCategory = $validated['damage_category'];
        if ($damageCategory === 'lainnya' && $request->custom_damage_category_input) {
            $damageCategory = $request->custom_damage_category_input;
        }
        
        $itemCondition = $request->item_condition;
        if ($itemCondition === 'lainnya' && $request->custom_item_condition_input) {
            $itemCondition = $request->custom_item_condition_input;
        }
        
        $booking = Booking::create([
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
            'description' => $validated['description'],
            'damage_category' => $damageCategory,
            'item_condition' => $itemCondition,
            'accessories_included' => $request->accessories_included,
            'status' => 'pending',
            'service_type' => 'dropoff',
            'scheduled_at' => now()
        ]);
        
        return redirect()->route('admin.reception.receipt', $booking)
            ->with('success', 'Penerimaan barang berhasil. Nomor servis: ' . $booking->id);
    }
    
    public function receipt(Booking $booking)
    {
        $booking->load(['user', 'service']);
        return view('admin.reception.receipt', compact('booking'));
    }
    
    public function printReceipt(Booking $booking)
    {
        $booking->load(['user', 'service']);
        $pdf = Pdf::loadView('pdf.reception-receipt', compact('booking'));
        return $pdf->download('tanda-terima-' . $booking->id . '.pdf');
    }
}