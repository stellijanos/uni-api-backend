<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $start_date = strtotime('2000-01-01');
        $end_date = strtotime('2005-12-31');

        // Generate a random timestamp within the range
        $random_timestamp = rand($start_date, $end_date);

        // Convert the timestamp to a date string
        $random_date = date('Y-m-d', $random_timestamp);
        $random_float = mt_rand(500, 1000) / 100;
        $grade = number_format($random_float, 2);

        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'birthDate' => $random_date,
            'login_token' => Str::random(64),
            'grade' => $grade
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
