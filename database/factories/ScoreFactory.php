<?php

namespace Database\Factories;

use App\Models\Score;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Score::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'points' => $this->faker->numberBetween(0, 300),
            'round' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['In progress', 'Confirmed']),
            'isactive' => $this->faker->boolean(90),
            'note' => $this->faker->optional(0.7)->sentence(),
            'team_name' => $this->faker->optional(0.8)->company(),
            'teammate1' => $this->faker->optional(0.9)->name(),
            'teammate1_score' => $this->faker->optional(0.9)->numberBetween(0, 300),
            'teammate2' => $this->faker->optional(0.8)->name(),
            'teammate2_score' => $this->faker->optional(0.8)->numberBetween(0, 300),
            'teammate3' => $this->faker->optional(0.7)->name(),
            'teammate3_score' => $this->faker->optional(0.7)->numberBetween(0, 300),
            'teammate4' => $this->faker->optional(0.6)->name(),
            'teammate4_score' => $this->faker->optional(0.6)->numberBetween(0, 300),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}