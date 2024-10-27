<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
            'password' => bcrypt('password'),
            'ip_address' => request()->ip(),
        ]);

        $user->assignRole('admin');
    }
}
