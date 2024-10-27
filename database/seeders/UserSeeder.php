<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'ip_address' => request()->ip(),
        ]);

        $user->assignRole('admin');

        User::create([
            'name' => 'yesa@gmail.com',
            'email' => 'yesa@gmail.com',
            'password' => Hash::make('yesa@gmail.com'),
            'ip_address' => '127.4.5.4',
        ]);

        User::create([
            'name' => 'ranu@gmail.com',
            'email' => 'ranu@gmail.com',
            'password' => Hash::make('ranu@gmail.com'),
            'ip_address' => '127.4.4.4',
        ]);

        User::create([
            'name' => 'perdi@gmail.com',
            'email' => 'perdi@gmail.com',
            'password' => Hash::make('perdi@gmail.com'),
            'ip_address' => '127.0.3.2',
        ]);
    }
}
