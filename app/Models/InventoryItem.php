<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryItem extends Model
{
    protected $fillable = [
        'product_id',
        'serial_number',
        'status',
        'preorder_id'
    ];

    public static function generateSerialNumber()
    {
        do {
            // Format: RT-YYYY-XXXXX (RT for Rosels Trading)
            $serial = 'RT-' . date('Y') . '-' . strtoupper(Str::random(5));
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
}
