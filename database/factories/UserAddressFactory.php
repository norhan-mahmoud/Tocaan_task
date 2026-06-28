<?php

namespace Database\Factories;

use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'building' => $this->faker->buildingNumber(),
            'floor' => $this->faker->randomDigitNotNull(),
            'apartment' => $this->faker->randomDigitNotNull(),
            'street' => $this->faker->streetName(),
            'created_at' => now(),
            'updated_at' => now(),

            //
        ];
    }

   
}
