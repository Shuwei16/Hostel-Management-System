<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Semester::create([
            'semester_name' => 'JULY 2023',
            'start_date' => '2023-06-20',
            'end_date' => '2023-11-13',
            'earliest_check_in_date' => '2023-06-20', //same as start date and end date
            'latest_check_out_date' => '2023-11-13',
            'price' => 1000,
            'new_reg_open_date' => '2023-05-25',    // 1 month before start date
            'new_reg_close_date' => '2023-11-13',
            'extension_reg_open_date' => '2023-05-01', // 2 month before start date
            'extension_reg_close_date' => '2023-05-24'
        ]);

        Semester::create([
            'semester_name' => 'NOVEMBER 2023',
            'start_date' => '2023-11-13',
            'end_date' => '2024-02-20',
            'earliest_check_in_date' => '2023-11-13', //same as start date and end date
            'latest_check_out_date' => '2024-02-20',
            'price' => 1000,
            'new_reg_open_date' => '2023-10-25',    // 1 month before start date
            'new_reg_close_date' => '2024-02-20',
            'extension_reg_open_date' => '2023-09-01', // 2 month before start date
            'extension_reg_close_date' => '2023-09-24'
        ]);
    }
}
