<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PendingUser extends Model
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

    public function getEmailForVerification()
    {
        return $this->email;
    }
}
