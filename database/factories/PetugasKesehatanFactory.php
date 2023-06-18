<?php

namespace Database\Factories;

use App\Models\PetugasKesehatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetugasKesehatan>
 */
class PetugasKesehatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PetugasKesehatan::class;
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'nama' => $this->faker->name,
            'nik' => $this->faker->unique()->randomNumber(8),
            'telp' => $this->faker->phoneNumber,
            'puskesmas' => $this->faker->company,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
