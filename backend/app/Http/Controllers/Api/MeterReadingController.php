<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeterReading;
use App\Models\Device;

class MeterReadingController extends Controller
{
    // GET /api/devices/{id}/readings

    public function getReadingsByDevice($deviceId)
    {
        $device = Device::findOrFail($deviceId);

        return response()->json($device->meterReadings);
    }

    // POST /api/meter-readings
    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'value' => 'required|integer',
            'recorded_at' => 'nullable|date',
        ]);

        $reading = MeterReading::create($data);

        return response()->json([
            'message' => 'Meter reading saved successfully',
            'data' => $reading
        ], 201);
    }
}
