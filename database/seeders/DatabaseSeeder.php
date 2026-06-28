<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test User',
            'last_name' => 'Last Name',
            'phone_number' => '1234567890',
            'email' => 'test@example.com',
        ]);

        //address for the user
        $user = User::first();
        $user->addresses()->create([
            'city' => 'Cairo',
            'country' => 'Egypt',
            'building' => 'Building 1',
            'floor' => '1',
            'street' => 'Street 1',
            'apartment' => '101',
        ]);
    }
}
