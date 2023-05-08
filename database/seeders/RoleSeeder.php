<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'user',
                'redirect_to' => '/home',
                'description' => 'Пользователь',
            ],
            [
                'name' => 'company',
                'redirect_to' => '/company',
                'description' => 'Компания',
            ],
            [
                'name' => 'admin',
                'redirect_to' => '/admin',
                'description' => 'Администратор',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
