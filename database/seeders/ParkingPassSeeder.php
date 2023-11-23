<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParkingApplication;

class ParkingPassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 15; $i++) {
            ParkingApplication::create([
                'student_id' => $i,
                'make' => 'Perodua',
                'model' => 'Axia',
                'year' => '2023',
                'color' => 'Black',
                'plate_no' => 'WWW1234',
                'status' => 'Pending Approval',
            ]);
        }
    }
}
