<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceComponent;
use App\Models\Technician;
use App\Notifications\BookingStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Booking::class);

        $query = Booking::with(['user', 'service', 'technician.user'])
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->date_range, function($q) use ($request) {
                return match($request->date_range) {
                    'today' => $q->whereDate('scheduled_at', today()),
                    'week' => $q->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $q->whereBetween('scheduled_at', [now()->startOfMonth(), now()->endOfMonth()]),
                    default => $q
                };
            })
            ->when($request->search, function($q) use ($request) {
                return $q->where(function($query) use ($request) {
                    $query->where('id', 'like', "%{$request->search}%")
                        ->orWhereHas('user', function($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%")
                                ->orWhere('email', 'like', "%{$request->search}%");
                        })
                        ->orWhereHas('service', function($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%");
                        });
                });
            });

        // Filter bookings based on user role
        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        $bookings = match($request->sort) {
            'oldest' => $query->oldest()->paginate(10),
            'upcoming' => $query->where('scheduled_at', '>=', now())->oldest('scheduled_at')->paginate(10),
            default => $query->latest()->paginate(10)
        };

        // Return different views based on user role
        if (auth()->user()->role === 'admin') {
            $technicians = Technician::with('user')->get();
            return view('admin.bookings.index', compact('bookings', 'technicians'));
        }

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::where('is_available', true)->get();
        $technicians = Technician::where('is_available', true)->get();
        $components = \App\Models\ServiceComponent::where('is_available', true)->get();
        return view('bookings.create', compact('services', 'technicians', 'components'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'technician_id' => 'required|exists:technicians,id',
            'description' => 'required|string',
            'service_type' => 'required|in:pickup,dropoff,onsite',
            'address' => 'required_if:service_type,pickup,onsite|nullable|string',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['is_emergency'] = $request->has('is_emergency');
        $validated['emergency_fee'] = $validated['is_emergency'] ? 100000 : 0;
        $service = Service::findOrFail($validated['service_id']);
        $validated['total_price'] = $service->price;
        if (in_array($validated['service_type'], ['pickup', 'onsite'])) {
            $validated['total_price'] += 50000;
        }
        if ($validated['is_emergency']) {
            $validated['total_price'] += 100000;
        }
        $booking = Booking::create($validated);
        // Kirim notifikasi WA ke teknisi
        $technician = Technician::find($validated['technician_id']);
        if ($technician && $technician->user && $technician->user->phone_number) {
            $serviceName = $service->name;
            $bookingDate = $booking->scheduled_at->format('d M Y H:i');
            $customerName = $booking->user->name;
            $message = "🔔 *Booking Baru Masuk*\n\nHalo {$technician->user->name},\nAnda mendapatkan booking baru untuk service *{$serviceName}* dari *{$customerName}* pada {$bookingDate}.\n\nSilakan cek dashboard teknisi Anda.";
            (new \App\Jobs\SendWhatsappNotification($technician->user->phone_number, $message))->handle();
        }
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function technicianIndex()
    {
        $bookings = \App\Models\Booking::with(['user', 'service'])
            ->where('technician_id', auth()->user()->technician->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('technician.bookings.index', compact('bookings'));
    }

    public function technicianShow(Booking $booking)
    {
        $this->authorize('viewAsTechnician', $booking);
        return view('technician.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $this->authorize('updateStatus', $booking);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $oldStatus = $booking->status;
        $booking->update([
            'status' => $validated['status'],
            'status_updated_by' => auth()->id()
        ]);

        // Tambahkan loyalty points jika status berubah menjadi completed
        if ($oldStatus !== 'completed' && $validated['status'] === 'completed') {
            \App::make(\App\Services\LoyaltyPointService::class)->addPoints($booking);
        }

        // Send notification to user about status change
        if ($oldStatus !== $validated['status']) {
            $serviceName = $booking->service->name;
            $bookingDate = $booking->scheduled_at->format('d M Y H:i');
            $customerName = $booking->user->name;
            $status = $validated['status'];
            switch ($status) {
                case 'pending':
                    $message = "🔔 *Update Status Booking*\n\nHalo {$customerName},\nBooking service *{$serviceName}* Anda pada {$bookingDate} telah diterima dan sedang menunggu konfirmasi.\n\nKami akan segera memproses booking Anda.";
                    break;
                case 'in_progress':
                    $message = "🔧 *Update Status Booking*\n\nHalo {$customerName},\nService *{$serviceName}* Anda pada {$bookingDate} sedang dalam proses perbaikan oleh teknisi kami.\n\nKami akan menginformasikan Anda jika ada perkembangan lebih lanjut.";
                    break;
                case 'completed':
                    $message = "✅ *Update Status Booking*\n\nHalo {$customerName},\nService *{$serviceName}* Anda pada {$bookingDate} telah selesai.\n\nTerima kasih telah menggunakan layanan kami. Kami tunggu kedatangan Anda kembali!";
                    break;
                case 'cancelled':
                    $message = "❌ *Update Status Booking*\n\nHalo {$customerName},\nMohon maaf, booking service *{$serviceName}* Anda pada {$bookingDate} telah dibatalkan.\n\nSilakan hubungi kami untuk informasi lebih lanjut.";
                    break;
                default:
                    $message = "📱 *Update Status Booking*\n\nHalo {$customerName},\nStatus booking service *{$serviceName}* Anda pada {$bookingDate} telah diubah menjadi: *{$status}*";
            }
            (new \App\Jobs\SendWhatsappNotification($booking->user->phone_number, $message))->handle();
        }

        return redirect()->back()
            ->with('success', 'Status booking berhasil diperbarui.');
    }

    public function addComponent(Request $request, Booking $booking)
    {
        $this->authorize('addComponent', $booking);

        $validated = $request->validate([
            'service_component_id' => 'required|exists:service_components,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $component = ServiceComponent::findOrFail($validated['service_component_id']);

        if ($component->stock < $validated['quantity']) {
            return redirect()->back()
                ->with('error', 'Insufficient stock for the selected component.');
        }

        DB::transaction(function () use ($booking, $component, $validated) {
            $booking->serviceComponents()->attach($component->id, [
                'quantity' => $validated['quantity'],
                'price_at_time' => $component->price,
            ]);

            $component->decrement('stock', $validated['quantity']);

            // Calculate total price including base service price, components, and delivery fee
            $basePrice = $booking->service->price;
            $componentsPrice = $booking->serviceComponents->sum(function ($component) {
                return $component->pivot->quantity * $component->pivot->price_at_time;
            });
            $deliveryFee = in_array($booking->service_type, ['pickup', 'onsite']) ? 50000 : 0;
            $loyaltyDiscount = $booking->loyalty_points_used ? ($booking->loyalty_points_used * 100) : 0;

            $booking->update([
                'total_price' => $basePrice + $componentsPrice + $deliveryFee - $loyaltyDiscount
            ]);
        });

        return redirect()->back()
            ->with('success', 'Component added successfully.');
    }

    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'service', 'technician'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $technicians = Technician::with('user')->get();
        return view('admin.bookings.index', compact('bookings', 'technicians'));
    }

    public function adminShow(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function reports()
    {
        $totalBookings = Booking::count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $averageRating = DB::table('ratings')->avg('rating');

        $monthlyBookings = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('admin.reports', compact(
            'totalBookings',
            'completedBookings',
            'totalRevenue',
            'averageRating',
            'monthlyBookings'
        ));
    }

    public function rate(Booking $booking)
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Hanya user yang dapat memberikan rating.');
        }
        
        $this->authorize('view', $booking);
        $rating = $booking->rating;
        $technicians = $booking->technician ? [$booking->technician] : [];
        return view('bookings.rate', compact('booking', 'rating', 'technicians'));
    }

    public function submitRate(Request $request, Booking $booking)
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Hanya user yang dapat memberikan rating.');
        }

        $this->authorize('view', $booking);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:255',
            'technician_id' => 'required|exists:technicians,id',
        ]);

        $booking->rating()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'rating' => $validated['rating'],
                'review' => $validated['review'] ?? null,
                'technician_id' => $validated['technician_id'],
            ]
        );

        return redirect()->route('bookings.show', $booking)->with('success', 'Terima kasih atas penilaian Anda!');
    }

    public function pay(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);
        if ($booking->status !== 'completed' || $booking->is_paid) {
            return redirect()->back()->with('error', 'Pembayaran hanya dapat dilakukan setelah service selesai dan belum dibayar.');
        }

        $validated = $request->validate([
            'ewallet_type' => 'required|in:ovo,dana,gopay,spay',
            'payment_proof' => 'required|image|max:2048',
        ]);

        // Simpan file bukti transfer
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $booking->update([
            'ewallet_type' => $validated['ewallet_type'],
            'payment_proof' => $proofPath,
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function verifyPayment(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking); // pastikan hanya admin
        if (!$booking->payment_proof || $booking->is_paid) {
            return redirect()->back()->with('error', 'Tidak ada bukti pembayaran atau sudah diverifikasi.');
        }
        $booking->update(['is_paid' => true]);
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function submitRepairReport(Request $request, Booking $booking)
    {
        $this->authorize('updateStatus', $booking); // pastikan teknisi yang bersangkutan
        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'Laporan hanya dapat diisi setelah status completed.');
        }
        $validated = $request->validate([
            'repair_report' => 'required|string',
        ]);
        $booking->update(['repair_report' => $validated['repair_report']]);
        return redirect()->back()->with('success', 'Laporan perbaikan berhasil disimpan.');
    }

    public function invoice(Booking $booking)
    {
        $this->authorize('view', $booking);
        if (!$booking->is_paid) {
            abort(403, 'Invoice hanya tersedia setelah pembayaran.');
        }
        $pdf = Pdf::loadView('bookings.invoice', compact('booking'));
        return $pdf->download('invoice-booking-' . $booking->id . '.pdf');
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);
        $booking->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Booking status updated!');
    }

    public function assignTechnician(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'technician_id' => 'required|exists:technicians,id',
        ]);

        $booking->update([
            'technician_id' => $validated['technician_id'],
        ]);

        // Kirim notifikasi ke teknisi
        $technician = Technician::find($validated['technician_id']);
        if ($technician && $technician->user && $technician->user->phone_number) {
            $serviceName = $booking->service->name;
            $bookingDate = $booking->scheduled_at->format('d M Y H:i');
            $customerName = $booking->user->name;
            $message = "🔔 *Booking Baru Masuk*\n\nHalo {$technician->user->name},\nAnda mendapatkan booking baru untuk service *{$serviceName}* dari *{$customerName}* pada {$bookingDate}.\n\nSilakan cek dashboard teknisi Anda.";
            (new \App\Jobs\SendWhatsappNotification($technician->user->phone_number, $message))->handle();
        }

        // Redirect sesuai role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Technician assigned successfully.');
        } elseif (auth()->user()->role === 'technician') {
            return redirect()->route('technician.bookings.show', $booking)
                ->with('success', 'Technician assigned successfully.');
        } else {
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Technician assigned successfully.');
        }
    }
}