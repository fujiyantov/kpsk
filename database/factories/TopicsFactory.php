<?php

namespace Database\Factories;

use App\Models\Topics;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicsFactory extends Factory
{
    protected $model = Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'category_id' => $this->faker->numberBetween(1,5),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->text(),
        ];
    }
}
