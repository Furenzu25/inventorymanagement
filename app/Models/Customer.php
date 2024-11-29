<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'address',
        'phone_number',
        'reference_contactperson',
        'reference_contactperson_phonenumber',
        'email',
        'valid_id',
        'valid_id_image',
        'profile_image',
    ];

    public function preorders()
    {
        return $this->hasMany(Preorder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function accountReceivables()
    {
        return $this->hasMany(AccountReceivable::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function paymentSubmissions()
    {
        return $this->hasMany(PaymentSubmission::class);
    }
}
