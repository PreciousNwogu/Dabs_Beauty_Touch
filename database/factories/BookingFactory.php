<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Box Braids',
            'Knotless Braids',
            'Feed-in Braids',
            'Cornrows',
            'Wig Installation',
            'Hair Extensions',
            'Silk Press',
            'Natural Hair Care'
        ];

        $times = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
        ];

        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'service' => $this->faker->randomElement($services),
            'appointment_date' => $this->faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'appointment_time' => $this->faker->randomElement($times),
            'message' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the booking is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the booking is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_date' => now()->format('Y-m-d'),
        ]);
    }
}
