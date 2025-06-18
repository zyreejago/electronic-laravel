<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technicians = Technician::with('user')->paginate(10);
        return view('technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('technicians.create');
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
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'technician',
            ]);

            Technician::create([
                'user_id' => $user->id,
                'specialization' => $validated['specialization'],
                'bio' => $validated['bio'] ?? null,
                'is_available' => $validated['is_available'] ?? true,
            ]);
        });

        return redirect()->route('technicians.index')
            ->with('success', 'Technician created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        return view('technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technician $technician)
    {
        return view('technicians.edit', compact('technician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $technician->user_id,
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $technician) {
            $technician->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $technician->update([
                'specialization' => $validated['specialization'],
                'bio' => $validated['bio'] ?? null,
                'is_available' => $validated['is_available'] ?? false,
            ]);
        });

        return redirect()->route('technicians.index')
            ->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        DB::transaction(function () use ($technician) {
            $technician->user->delete();
            $technician->delete();
        });

        return redirect()->route('technicians.index')
            ->with('success', 'Technician deleted successfully.');
    }
}
