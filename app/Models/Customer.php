<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birthday',
        'address',
        'phone_number',
        'reference_contactperson',
        'reference_contactperson_phonenumber',
        'email',
        'valid_id',
        'valid_id_image',
    ];

    public function preorders()
    {
        return $this->hasMany(Preorder::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
