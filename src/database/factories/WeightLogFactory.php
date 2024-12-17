<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WeightLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = WeightLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 40, 100),
            'calories' => $this->faker->numberBetween(500, 4000),
            'exercise_time' => $this->faker->time($format = 'H:i'),
            'exercise_content' => $this->faker->sentence(3),
        ];
    }
}
