<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password') // Replace with a secure password
            ]
        );
        $admin->assignRole('admin');

        // Create Guru User
        $guru = User::firstOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'name' => 'Guru User',
                'password' => Hash::make('password') // Replace with a secure password
            ]
        );
        $guru->assignRole('guru');

        // Create Siswa User
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Siswa User',
                'password' => Hash::make('password') // Replace with a secure password
            ]
        );
        $siswa->assignRole('siswa');
    }
}
