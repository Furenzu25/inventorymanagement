<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
        // Specify which fields are mass assignable
        protected $fillable = [
            'name',
            'age',
            'address',
            'phone_number',
            'email',
            'valid_id',
            'valid_id_image',
        ];

        // Define the relationship between the Customer and Preorder models
        public function preorders()
        {
            return $this->hasMany(Preorder::class);
        }
}
