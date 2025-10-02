<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
     protected $fillable = [
        'order_id',
        'amount',
        'status',
        'gateway_reference',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Optional helper to mark payment as successful
    public function markAsSuccess()
    {
        $this->status = 'success';
        $this->save();
    }

    // Optional helper to mark payment as failed
    public function markAsFailed()
    {
        $this->status = 'failed';
        $this->save();
    }
}
