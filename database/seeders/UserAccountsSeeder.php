<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserAccountsSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
        Role::create(['name' => 'project manager']);
        Role::create(['name' => 'employee']);
        $user = User::create([
            'first_name' => 'Mark',
            'last_name' => 'Casero',
            'email' => 'mark@gmail.com',
            'gender' => 'male',
            'phone_number' => '09123456789',
            'password' => 'password',
        ]);
        $user = User::createQuietly([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@gmail.com',
            'gender' => 'male',
            'phone_number' => '09123456789',
            'password' => 'password',
        ]);
        $user->assignRole('admin');
        $user = User::createQuietly([
            'first_name' => 'Employee',
            'last_name' => 'User',
            'email' => 'employee@gmail.com',
            'gender' => 'female',
            'phone_number' => '09123456789',
            'password' => 'password',
        ]);
        $user->assignRole('employee');
        $user = User::createQuietly([
            'first_name' => 'Project Manager',
            'last_name' => 'User',
            'email' => 'projectmanager@gmail.com',
            'gender' => 'female',
            'phone_number' => '09123456789',
            'password' => 'password',
        ]);
        $user->assignRole('project manager');

    }
}
