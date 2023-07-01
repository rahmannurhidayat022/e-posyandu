<?php

namespace Database\Seeders;

use App\Models\Posko;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'nama' => 'Super User',
                'role' => 'admin',
                'posko_id' => null,
                'password' => Hash::make('admin123')
            ],
            [
                'username' => 'operator',
                'nama' => 'Kader ABC',
                'role' => 'operator',
                'posko_id' => null,
                'password' => Hash::make('operator123')
            ],
            [
                'username' => 'viewer',
                'nama' => 'Viewer',
                'role' => 'viewer',
                'posko_id' => null,
                'password' => Hash::make('viewer123')
            ]
        ];

        foreach ($users as $user) {
            $userData = $user;
            if ($userData['role'] == 'operator') {
                $posko = Posko::factory()->create();
                $userData['posko_id'] = $posko->id;
            }
            User::create($userData);
        }
    }
}

