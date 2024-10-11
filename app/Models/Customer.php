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
            'birthday',
            'address',
            'phone_number',
            'reference_contactperson',
            'reference_contactperson_phonenumber',
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
