<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                // 'name' => fake()->name(),
                'first_name' => config('admin.FIRST_NAME'),
                'last_name' => config('admin.LAST_NAME'),
                'staff_id' => config('admin.STAFFID'),
                'department' => config('admin.DEPARTMENT'),
                'role_id' => env('ADMIN'),
                // 'email' => fake()->unique()->safeEmail(),
                'email' => config('admin.EMAIL'),
                'phone' => config('admin.PHONE'),
                'state_of_origin' => config('admin.STATE_OF_ORIGIN'),
                'employee_type' => config('admin.EMPLOYEE_TYPE'),
                'address' => config('admin.ADDRESS'),
                'gender' => config('admin.GENDER'),
                'role_id' => config('admin.ROLEID'),
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make(config('admin.PASSWORD')),
                'remember_token' => Str::random(10),


            // 'name' => $this->faker->name(),
            // 'department' => $this->faker->word(),
            // 'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => static::$password ??= Hash::make(), // default password
            // 'remember_token' => Str::random(10),
            // 'role_id' => $this->faker->randomDigit(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}