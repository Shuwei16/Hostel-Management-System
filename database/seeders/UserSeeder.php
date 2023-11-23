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
        //admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@testing.com',
            'password' => bcrypt('admin123'),
            'role' => 2,
        ]);

        //dummy data for 200 resident accounts
        for($i=1; $i <= 200; $i++) {
            User::create([
                'name' => 'User Name '.$i,
                'email' => 'user'.$i.'@testing.com',
                'password' => bcrypt('user123'),
                'role' => 1,
            ]);
        }

        //dummy data for 10 non-resident accounts
        for($i=201; $i <= 210; $i++) {
            User::create([
                'name' => 'User Name '.$i,
                'email' => 'user'.$i.'@testing.com',
                'password' => bcrypt('user123'),
                'role' => 0,
            ]);
        }
    }
}
