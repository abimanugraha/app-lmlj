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
            'masalah_id' => $this->faker->numberBetween(1, 15),
            'jawaban_id' => $this->faker->numberBetween(1, 50),
            'file' => $this->faker->word(),
        ];
    }
}
