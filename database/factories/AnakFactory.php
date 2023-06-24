<?php

namespace Database\Factories;

use App\Models\Ibu;
use App\Models\Posko;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anak>
 */
class AnakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'posko_id' => function () {
                return Posko::factory()->create()->id;
            },
            'ibu_id' => function () {
                return Ibu::factory()->create()->id;
            },
            'nama' => $this->faker->name,
            'nik' => $this->faker->unique()->randomNumber(8),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['lk', 'pr']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
