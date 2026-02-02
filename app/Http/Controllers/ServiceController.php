<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = \App\Models\Service::where('is_active', true)->get()->groupBy('category');
        return view('services', compact('services'));
    }

    public function show($id)
    {
        $service = \App\Models\Service::findOrFail($id);
        $relatedServices = \App\Models\Service::where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->take(3)
            ->get();
            
        return view('services.show', compact('service', 'relatedServices'));
    }

    public function create()
    {
        $services = \App\Models\Service::where('is_active', true)->get()->groupBy('category');
        return view('appointment', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'vehicle_make' => 'required|string|max:255',
            'vehicle_model' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'licence_plate' => 'nullable|string|max:50',
            'notes' => 'nullable|string'
        ]);

        $appointment = \App\Models\Appointment::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'vehicle_make' => $request->vehicle_make,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_type' => $request->vehicle_type,
            'licence_plate' => $request->licence_plate,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        $appointment->services()->sync($request->service_ids);
        
        return back()->with('success', 'APPOINTMENT SECURED. STUDIO SCHEDULED.');
    }
}
