<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrxAbsensi>
 */
class TrxAbsensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_karyawan' => mt_rand(1,5),
            'keterangan' => fake()->randomElement(['masuk' ,'pulang']),
            'catatan' => fake()->sentence(),
            'waktu' => fake()->date('Y-m-d'),
            'foto' => 'fotos/'.fake()->word().'.png',
            'longitude' => fake()->randomNumber(7, true),
            'latitude' => fake()->randomNumber(7, true),
        ];
    }
}
