<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'serial_number',
        'api_key',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class);
    }
}
