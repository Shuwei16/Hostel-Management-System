<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@123.com',
            'password' => bcrypt('admin123'),
            'role' => 2,
        ]);

        User::create([
            'name' => 'User1',
            'email' => 'user1@123.com',
            'password' => bcrypt('user123'),
            'role' => 1,
        ]);

        User::create([
            'name' => 'User2',
            'email' => 'user2@123.com',
            'password' => bcrypt('user123'),
            'role' => 0,
        ]);
    }
}
