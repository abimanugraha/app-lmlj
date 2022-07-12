<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerbaikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'jawaban_id' => $this->faker->numberBetween(1, 50),
            'perbaikan' => $this->faker->text(76),
        ];
    }
}
