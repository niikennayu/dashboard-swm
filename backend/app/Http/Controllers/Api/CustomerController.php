<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // GET /api/customers
    public function index()
    {
        $customers = Customer::paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'List customers',
            'data' => $customers
        ], 200);
    }

    // POST /api/customers
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_pelanggan' => 'required|string|max:100|unique:customers,nomor_pelanggan',
            'alamat' => 'required|string',
        ]);

        $customer = Customer::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully',
            'data' => $customer
        ], 201);
    }

    // GET /api/customers/{id}
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer detail',
            'data' => $customer
        ], 200);
    }

    // PUT /api/customers/{id}
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_pelanggan' => 'required|string|max:100|unique:customers,nomor_pelanggan,' . $customer->id,
            'alamat' => 'required|string',
        ]);

        $customer->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer updated successfully',
            'data' => $customer
        ], 200);
    }

    // DELETE /api/customers/{id}
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully'
        ], 200);
    }
}
