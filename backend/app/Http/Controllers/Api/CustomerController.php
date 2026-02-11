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
        return response()->json(Customer::all());
    }

    // POST /api/customers
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'nomor_pelanggan' => 'required|string|unique:customers,nomor_pelanggan',
            'alamat' => 'required|string',
        ]);

        $customer = Customer::create($data);

        return response()->json($customer, 201);
    }

    // GET /api/customers/{id}
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    // PUT /api/customers/{id}
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string',
            'nomor_pelanggan' => 'required|string|unique:customers,nomor_pelanggan,' . $customer->id,
            'alamat' => 'required|string',
        ]);

        $customer->update($data);

        return response()->json($customer);
    }

    // DELETE /api/customers/{id}
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Customer deleted']);
    }
}
