<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, InteractsWithSockets, \Illuminate\Auth\MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->is_admin === true;
    }   

    public function setAsAdmin()
    {
        $this->is_admin = true;
        $this->save();
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function createCustomerProfile($customerData)
    {
        $customerData['user_id'] = $this->id;
        return $this->customer()->create($customerData);
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
                    ->whereNull('read_at');
    }
}
