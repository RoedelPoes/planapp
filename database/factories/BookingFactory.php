<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     * 
     *
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 week', '+1 week');
        $endDate = (clone $startDate)->modify('+1 hour');

        return [
            //
            'title' => $this->faker->sentence(3),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => User::factory(),
        ];
    }
}
