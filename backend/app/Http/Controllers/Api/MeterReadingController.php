<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeterReading;
use App\Models\Device;
use App\Models\Alert;
use Carbon\Carbon;


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

        if (!isset($data['recorded_at'])) {
            $data['recorded_at'] = now();
        }

        $reading = MeterReading::create($data);

        // Auto check anomaly
        $this->checkAnomaly($reading);

        return response()->json([
            'message' => 'Meter reading saved successfully',
            'data' => $reading
        ], 201);
    }

     private function checkAnomaly(MeterReading $reading)
    {
        $device = Device::with('customer')->find($reading->device_id);
        if (!$device || !$device->customer) return;

        $currentMonth = Carbon::parse($reading->recorded_at)->format('Y-m');
        $lastMonth    = Carbon::parse($reading->recorded_at)->subMonth()->format('Y-m');

        // Total bulan ini
        $currentUsage = MeterReading::where('device_id', $device->id)
            ->whereRaw("to_char(recorded_at, 'YYYY-MM') = ?", [$currentMonth])
            ->sum('value');

        // Total bulan lalu
        $lastUsage = MeterReading::where('device_id', $device->id)
            ->whereRaw("to_char(recorded_at, 'YYYY-MM') = ?", [$lastMonth])
            ->sum('value');

        if ($lastUsage > 0) {
            $increasePercent = (($currentUsage - $lastUsage) / $lastUsage) * 100;

            if ($increasePercent > 50) {
                Alert::create([
                    'customer_id' => $device->customer->id,
                    'message' => "Lonjakan pemakaian air " . round($increasePercent, 2) . "% dibanding bulan lalu",
                    'type' => $increasePercent > 100 ? 'danger' : 'warning',
                    'is_read' => false,
                ]);
            }
        }
    }
}

