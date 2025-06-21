<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->withCount('bookings')
            ->with(['bookings' => function($q) {
                $q->latest()->limit(1);
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        $customer->load(['bookings.service', 'bookings.technicians.user', 'loyaltyPoints']);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'required|string|min:10|max:15',
        ]);

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        // Check if customer has active bookings
        $activeBookings = $customer->bookings()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count();
        
        if ($activeBookings > 0) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete customer with active bookings.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Show form to change customer password
     */
    public function changePasswordForm(User $customer)
    {
        return view('admin.customers.change-password', compact('customer'));
    }

    /**
     * Update customer password
     */
    public function changePassword(Request $request, User $customer)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Reset customer password to default
     */
    public function resetPassword(User $customer)
    {
        $newPassword = 'password123';
        $customer->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', "Password reset successfully. New password: {$newPassword}");
    }
}