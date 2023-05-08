<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Лялина Анастасия Викторовна',
            'email' => '86nootka36@gmail.com',
            'password' => Hash::make('Pa$$w0rd'),
            'role_id' => 1,
        ];

        User::create($user);
    }
}
