<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\Customer;

class BillingController extends Controller
{
    // GET /api/customers/{id}/billing
    public function getBillingByCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $billings = Billing::where('customer_id', $customer->id)
            ->orderBy('period', 'desc')
            ->get();

        return response()->json($billings);
    }

    // POST /api/billing/generate
    public function generate(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_usage' => 'required|integer|min:0',
            'amount' => 'required|integer|min:0',
            'period' => 'required|date',
        ]);

        // Cegah duplicate billing untuk customer + period yang sama
        $existing = Billing::where('customer_id', $data['customer_id'])
            ->where('period', $data['period'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Billing for this period already exists',
                'data' => $existing
            ], 409);
        }

        $billing = Billing::create([
            'customer_id' => $data['customer_id'],
            'total_usage' => $data['total_usage'],
            'amount' => $data['amount'],
            'is_paid' => false,
            'period' => $data['period'],
        ]);

        return response()->json([
            'message' => 'Billing generated successfully',
            'data' => $billing
        ], 201);
    }
}