<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JawabanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'masalah_id' => $this->faker->numberBetween(1, 14),
            // 'analisa' => $this->faker->text(150),
            'urgensi' => $this->faker->numberBetween(1, 3),
            'target' => $this->faker->numberBetween(1, 3),
            'status' => $this->faker->numberBetween(0, 1),
            // 'tanggal_diterima' => $this->faker->dateTime(),
            'penerima_id' => $this->faker->numberBetween(1, 10),
            'nilai_tambah' => $this->faker->text(96),
            'keputusan' => $this->faker->text(137),
            'pic_id' => $this->faker->numberBetween(1, 10),
            'unit_tujuan_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
