<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KomponenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'masalah_id' => $this->faker->numberBetween(0, 2),
            'produk_id' => $this->faker->numberBetween(1, 10),
            'nama' => $this->faker->unique()->word(),
            'nomor' => $this->faker->numerify('#####'),
        ];
    }
}
