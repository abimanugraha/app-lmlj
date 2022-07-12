<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnalisaFactory extends Factory
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
            'analisa' => $this->faker->text(50),
        ];
    }
}
