<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_usage',
        'amount',
        'is_paid',
        'period',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'period' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
