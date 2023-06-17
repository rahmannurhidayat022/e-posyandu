<?php

namespace Database\Seeders;

use App\Models\Antropometri;
use Illuminate\Database\Seeder;

class AntropometriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('antropometri_data.csv');
        $file = fopen($csvFile, 'r');
        if ($file) {
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $jenis_kelamin = $data[0];
                $bulan = $data[1];
                $bb_min = $data[2];
                $bb_max = $data[3];
                $tb_min = $data[4];
                $tb_max = $data[5];

                Antropometri::create([
                    'jenis_kelamin' => $jenis_kelamin,
                    'bulan' => $bulan,
                    'bb_min' => $bb_min,
                    'bb_max' => $bb_max,
                    'tb_min' => $tb_min,
                    'tb_max' => $tb_max,
                ]);
            }
            fclose($file);
        }
    }
}
