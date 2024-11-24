<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class InventoryItem extends Model
{
    protected $fillable = [
        'product_id',
        'serial_number',
        'status',
        'preorder_id',
        'picked_up_at',
        'picked_up_by',
        'pickup_verification',
        'pickup_notes',
        'bought_location',
        'bought_date',
    ];

    protected $casts = [
        'picked_up_at' => 'datetime',
        'bought_date' => 'datetime',
    ];

    public static function generateSerialNumber($productId)
    {
        do {
            // Format: RT-{PRODUCT_ID}-{YEAR}-{RANDOM}
            // Example: RT-001-2024-XY123
            $serial = sprintf(
                'RT-%03d-%s-%s',
                $productId,
                date('Y'),
                strtoupper(Str::random(5))
            );
        } while (static::where('serial_number', $serial)->exists());

        return $serial;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function preorder()
    {
        return $this->belongsTo(Preorder::class);
    }

    public function pickedUpBy()
    {
        return $this->belongsTo(User::class, 'picked_up_by');
    }
}
