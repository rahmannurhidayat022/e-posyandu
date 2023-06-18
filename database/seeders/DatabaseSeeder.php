<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Anak;
use App\Models\Kader;
use App\Models\Lansia;
use App\Models\LingkupPosko;
use App\Models\PetugasKesehatan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(AntropometriSeeder::class);
        LingkupPosko::factory()->count(14)->create();
        PetugasKesehatan::factory()->count(9)->create();
        Anak::factory()->count(15)->create();
        Lansia::factory()->count(10)->create();
        Kader::factory()->count(14)->create();
    }
}
