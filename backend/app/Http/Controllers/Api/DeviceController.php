<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index()
    {
        return response()->json(Device::with('customer')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'serial_number' => 'required|string|unique:devices,serial_number',
        ]);

        $data['api_key'] = Str::random(40);

        $device = Device::create($data);

        return response()->json([
            'message' => 'Device created successfully',
            'data' => $device
        ], 201);
    }

    public function show($id)
    {
        $device = Device::with('customer')->findOrFail($id);
        return response()->json($device);
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $data = $request->validate([
            'serial_number' => 'required|string|unique:devices,serial_number,' . $device->id,
        ]);

        $device->update($data);

        return response()->json([
            'message' => 'Device updated',
            'data' => $device
        ]);
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return response()->json([
            'message' => 'Device deleted'
        ]);
    }
}
