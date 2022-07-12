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
            'nolmlj' => $this->faker->unique()->numerify('UNIT-LMLJ-06-22-###'),
            'produk_id' => $this->faker->numberBetween(1, 10),
            'komponen_id' => $this->faker->numberBetween(1, 30),
            'unit_id' => $this->faker->numberBetween(1, 9),
            'masalah' => $this->faker->sentence(3),
            'nilai_tambah' => $this->faker->sentence(5),
            'urgensi' => $this->faker->numberBetween(1, 3),
            'pengaju_id' => $this->faker->numberBetween(1, 3),
            'ygmengetahui_id' => $this->faker->numberBetween(3, 6),
            'status' => $this->faker->numberBetween(1, 3),
            'keterangan' => $this->faker->sentence(6),
        ];
    }
}
