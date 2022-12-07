<?php

namespace Database\Factories;

use App\Models\Schedules;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchedulesFactory extends Factory
{
    protected $model = Schedules::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_id' => 4,
            'psikolog_id' => 3,
            'topic_id' => $this->faker->numberBetween(1,5),
            'date' => $this->faker->date(),
            'type' => $this->faker->numberBetween(1,2),
            'diagnosis' => $this->faker->text(),
            'status' => 1,
        ];
    }
}
