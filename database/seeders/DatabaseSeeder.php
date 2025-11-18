<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role Admin & User
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Admin']
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['display_name' => 'User']
        );

        // Buat user admin default
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'no_hp' => '08123456789'
            ]
        );

        
         $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'no_hp' => '08123456789'
            ]
        );

        // Hubungkan role admin ke user admin
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // (Opsional) Tambahkan user biasa untuk tes
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'username' => 'user',
                'password' => Hash::make('password'),
                'no_hp' => '08123456780'
            ]
        );
        $user->roles()->syncWithoutDetaching([$userRole->id]);
    }
}
