<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitorRegistration;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //dummy data for visitor registration record
        for($i=1; $i <= 15; $i++) {

            VisitorRegistration::create([
                'student_id' => rand(1, 5),
                'visitor_name' => 'Lee Ah Meng',
                'visit_purpose' => 'Drop luggages',
                'visit_date' => '2023-11-23',
                'visit_time' => "9:00:00",
                'duration' => "10",
                'status' => 'Pending Approval',
            ]);
        }
    }
}
