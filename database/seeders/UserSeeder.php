<?php

namespace Database\Seeders;

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
                'role' => 'admin',
                'password' => Hash::make('admin123')
            ],
            [
                'username' => 'operator',
                'role' => 'operator',
                'password' => Hash::make('operator123')
            ],
            [
                'username' => 'viewer',
                'role' => 'viewer',
                'password' => Hash::make('viewer123')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    
    }
}