<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'message',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
