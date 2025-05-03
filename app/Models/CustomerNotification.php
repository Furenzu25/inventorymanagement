<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;

    protected $table = 'customer_notifications';

    protected $fillable = [
        'customer_id',
        'title',
        'message',
        'type',
        'is_read',
        'cancellation_reason'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}