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
        ParkingApplication::create([
            'student_id' => 1,
            'make' => 'Perodua',
            'model' => 'Axia',
            'year' => '2023',
            'color' => 'Black',
            'plate_no' => 'WPV8180',
            'status' => 'Approved',
        ]);

        ParkingApplication::create([
            'student_id' => 2,
            'make' => 'Perodua',
            'model' => 'Axia',
            'year' => '2023',
            'color' => 'Black',
            'plate_no' => 'JFC2218',
            'status' => 'Pending Approval',
        ]);
    }
}
