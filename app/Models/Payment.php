<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
    'preorder_id', 
    'customer_id', 
    'sale_id', 
    'total_paid',
    'payment_date',
    'due amount'
];
    public function preorder(){
        return $this->belongsTo(Preorder::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
}
