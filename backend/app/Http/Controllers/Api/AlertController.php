<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Models\Customer;

class AlertController extends Controller
{
    // GET /api/customers/{id}/alerts
    public function getAlertsByCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $alerts = Alert::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($alerts);
    }

    // POST /api/alerts
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'message' => 'required|string',
        ]);

        $alert = Alert::create($data);

        return response()->json([
            'message' => 'Alert created successfully',
            'data' => $alert
        ], 201);
    }

    // POST /api/alerts/check-usage
    public function checkUsage(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_usage' => 'required|integer|min:0',
        ]);

        // Contoh rule sederhana:
        // Jika pemakaian > 100 m3, buat alert
        if ($data['total_usage'] > 100) {
            $message = "Pemakaian air tinggi terdeteksi: " . $data['total_usage'] . " m3";

            $alert = Alert::create([
                'customer_id' => $data['customer_id'],
                'message' => $message,
            ]);

            return response()->json([
                'message' => 'High usage alert created',
                'data' => $alert
            ], 201);
        }

        return response()->json([
            'message' => 'Usage is normal, no alert created'
        ]);
    }
}