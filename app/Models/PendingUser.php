<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PendingUser extends Model implements MustVerifyEmail
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'verification_token'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pendingUser) {
            $pendingUser->verification_token = Str::random(60);
        });
    }

    public function hasVerifiedEmail()
    {
        return false;
    }

    public function markEmailAsVerified()
    {
        // This method is not needed for PendingUser
    }

    public function sendEmailVerificationNotification()
    {
        // This method is not needed as we're sending the email in the Register component
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }
}
