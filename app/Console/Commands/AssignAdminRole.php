<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class AssignAdminRole extends Command
{
    protected $signature = 'user:assign-admin {email}';
    protected $description = 'Assign admin role to a user by email';

    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User dengan email '{$email}' tidak ditemukan!");
            return 1;
        }

        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->error("Role 'admin' tidak ditemukan! Jalankan: php artisan db:seed --class=RoleSeeder");
            return 1;
        }

        // Sync role admin ke user
        $user->roles()->sync([$adminRole->id]);

        $this->info("Berhasil! User '{$email}' sekarang memiliki role ADMIN.");
        $this->info("Silakan logout dan login kembali untuk menerapkan perubahan.");
        
        return 0;
    }
}
