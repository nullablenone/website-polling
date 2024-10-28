<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin user
        $admin = User::create([
            'name' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'ip_address' => request()->ip(),
        ]);
        $admin->assignRole('admin');

        // List of regular users
        $users = [
            [
                'name' => 'yesa@gmail.com',
                'email' => 'yesa@gmail.com',
                'password' => Hash::make('yesa@gmail.com'),
                'ip_address' => '127.4.5.4',
            ],
            [
                'name' => 'ranu@gmail.com',
                'email' => 'ranu@gmail.com',
                'password' => Hash::make('ranu@gmail.com'),
                'ip_address' => '127.4.4.4',
            ],
            [
                'name' => 'perdi@gmail.com',
                'email' => 'perdi@gmail.com',
                'password' => Hash::make('perdi@gmail.com'),
                'ip_address' => '127.0.3.2',
            ],
        ];

        // Loop untuk buat user biasa dan insert batas_polling
        foreach ($users as $userData) {
            $user = User::create($userData);

            // Insert batas_polling untuk user yang bukan admin
            DB::table('batas_pollings')->insert([
                'user_id' => $user->id,
                'ip_address' => $user->ip_address,
                'jumlah_polling' => 0,
                'batas_polling' => 3,
            ]);
        }
    }
}
