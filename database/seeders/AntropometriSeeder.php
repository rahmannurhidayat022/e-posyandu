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
        $csvFile = database_path('antropometri.csv');
        $file = fopen($csvFile, 'r');
        if ($file) {
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $tipe = $data[0];
                $jenis_kelamin = $data[1];
                $bulan = $data[2];
                $minus_3_sd = $data[3];
                $minus_2_sd = $data[4];
                $minus_1_sd = $data[5];
                $median = $data[6];
                $plus_1_sd = $data[7];
                $plus_2_sd = $data[8];
                $plus_3_sd = $data[9];

                Antropometri::create([
                    'tipe' => $tipe,
                    'jenis_kelamin' => $jenis_kelamin,
                    'bulan' => $bulan,
                    'minus_3_sd' => $minus_3_sd,
                    'minus_2_sd' => $minus_2_sd,
                    'minus_1_sd' => $minus_1_sd,
                    'median' => $median,
                    'plus_1_sd' => $plus_1_sd,
                    'plus_2_sd' => $plus_2_sd,
                    'plus_3_sd' => $plus_3_sd,
                ]);
            }
            fclose($file);
        }
    }
}
