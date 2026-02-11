<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_pelanggan',
        'alamat',
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
