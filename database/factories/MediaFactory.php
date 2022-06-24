<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'masalah_id' => $this->faker->numberBetween(0, 2),
            'jawaban_id' => $this->faker->numberBetween(0, 2),
            'file' => $this->faker->word(),
        ];
    }
}
