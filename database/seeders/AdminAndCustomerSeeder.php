<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAndCustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->setAsAdmin();

        // Create Regular User with Customer Profile
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user->createCustomerProfile([
            'name' => 'John Doe',
            'birthday' => '1990-01-01',
            'address' => '123 Main St, City',
            'phone_number' => '1234567890',
            'email' => 'john@example.com',
            'valid_id' => 'Driver\'s License',
            'reference_contactperson' => 'Jane Doe',
            'reference_contactperson_phonenumber' => '0987654321',
        ]);

        // Create a few more test customers
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Test User {$i}",
                'email' => "test{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->createCustomerProfile([
                'name' => "Test User {$i}",
                'birthday' => '1990-01-01',
                'address' => "{$i} Test Street, City",
                'phone_number' => "123456789{$i}",
                'email' => "test{$i}@example.com",
                'valid_id' => 'Driver\'s License',
                'reference_contactperson' => "Reference {$i}",
                'reference_contactperson_phonenumber' => "098765432{$i}",
            ]);
        }
    }
} 