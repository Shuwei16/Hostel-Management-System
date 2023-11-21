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
            'semester_name' => 'NOVEMBER 2022',
            'start_date' => '2022-11-11',
            'end_date' => '2023-02-07',
            'earliest_check_in_date' => '2022-11-11', //same as start date and end date
            'latest_check_out_date' => '2023-02-07',
            'price' => 1000,
            'new_reg_open_date' => '2022-10-11',    // 1 month before start date
            'new_reg_close_date' => '2023-02-07',
            'extension_reg_open_date' => '2022-09-11', // 2 month before start date
            'extension_reg_close_date' => '2022-10-10'
        ]);

        Semester::create([
            'semester_name' => 'FEBRUARY 2023',
            'start_date' => '2023-02-08',
            'end_date' => '2023-06-19',
            'earliest_check_in_date' => '2023-02-08', //same as start date and end date
            'latest_check_out_date' => '2023-02-07',
            'price' => 1000,
            'new_reg_open_date' => '2023-01-08',    // 1 month before start date
            'new_reg_close_date' => '2023-06-19',
            'extension_reg_open_date' => '2022-12-08', // 2 month before start date
            'extension_reg_close_date' => '2023-01-07'
        ]);

        Semester::create([
            'semester_name' => 'JUNE 2023',
            'start_date' => '2023-06-20',
            'end_date' => '2023-11-13',
            'earliest_check_in_date' => '2023-06-20', //same as start date and end date
            'latest_check_out_date' => '2023-11-13',
            'price' => 1000,
            'new_reg_open_date' => '2023-05-20',    // 1 month before start date
            'new_reg_close_date' => '2023-11-13',
            'extension_reg_open_date' => '2023-04-20', // 2 month before start date
            'extension_reg_close_date' => '2023-05-19'
        ]);

        Semester::create([
            'semester_name' => 'NOVEMBER 2023',
            'start_date' => '2023-11-14',
            'end_date' => '2024-02-05',
            'earliest_check_in_date' => '2023-11-14', //same as start date and end date
            'latest_check_out_date' => '2024-02-05',
            'price' => 1000,
            'new_reg_open_date' => '2023-10-14',    // 1 month before start date
            'new_reg_close_date' => '2024-02-05',
            'extension_reg_open_date' => '2023-09-14', // 2 month before start date
            'extension_reg_close_date' => '2023-10-13'
        ]);

        Semester::create([
            'semester_name' => 'FEBRUARY 2024',
            'start_date' => '2024-02-06',
            'end_date' => '2024-08-05',
            'earliest_check_in_date' => '2024-02-06', //same as start date and end date
            'latest_check_out_date' => '2024-08-05',
            'price' => 1000,
            'new_reg_open_date' => '2024-01-06',    // 1 month before start date
            'new_reg_close_date' => '2024-08-05',
            'extension_reg_open_date' => '2023-12-06', // 2 month before start date
            'extension_reg_close_date' => '2024-01-05'
        ]);
    }
}
