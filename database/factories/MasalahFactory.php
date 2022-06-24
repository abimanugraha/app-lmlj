<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MasalahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nolmlj' => $this->faker->unique()->numerify('UNIT-LMLJ/##/22/-###'),
            'produk_id' => $this->faker->numberBetween(0, 9),
            'komponen_id' => $this->faker->numberBetween(0, 29),
            'unit_id' => $this->faker->numberBetween(0, 3),
            'nilai_tambah' => $this->faker->sentence(4),
            'urgensi' => $this->faker->numberBetween(0, 3),
            'user_id' => $this->faker->numberBetween(0, 3),
            'status' => $this->faker->numberBetween(0, 2),
            'keterangan' => $this->faker->sentence(6),
        ];
    }
}
