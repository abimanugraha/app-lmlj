<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetailMasalahFactory extends Factory
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
            'detail' => $this->faker->text(100),
        ];
    }
}
