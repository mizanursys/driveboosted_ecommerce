<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'phone' => 'required|string|min:10|max:15',
                'source' => 'nullable|string|max:50',
            ]);

            // Check if this phone number was already captured recently (prevents spam)
            $existing = Lead::where('phone', $validated['phone'])
                ->where('created_at', '>', now()->subDay())
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'message' => 'Number already registered!'
                ]);
            }

            // Create the lead
            Lead::create([
                'phone' => $validated['phone'],
                'source' => $validated['source'] ?? 'homepage_modal',
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you! We will contact you shortly.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['phone'][0] ?? 'Invalid phone number.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lead Capture Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
