<?php

namespace App\Http\Controllers;

use App\Models\ServiceComponent;
use Illuminate\Http\Request;

class ServiceComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $components = ServiceComponent::paginate(10);
        return view('service-components.index', compact('components'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service-components.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        ServiceComponent::create($validated);

        return redirect()->route('service-components.index')
            ->with('success', 'Component created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceComponent $serviceComponent)
    {
        return view('service-components.show', compact('serviceComponent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceComponent $serviceComponent)
    {
        return view('service-components.edit', compact('serviceComponent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceComponent $serviceComponent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $serviceComponent->update($validated);

        return redirect()->route('service-components.index')
            ->with('success', 'Component updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceComponent $serviceComponent)
    {
        $serviceComponent->delete();

        return redirect()->route('service-components.index')
            ->with('success', 'Component deleted successfully.');
    }
}
