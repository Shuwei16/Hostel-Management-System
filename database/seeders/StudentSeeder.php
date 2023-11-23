<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //dummy data for female residents
        for($i=1; $i <= 150; $i++) {
            $races = ['Chinese', 'Malay', 'Indian'];
            $randomRaceIndex = mt_rand(0, count($races) - 1);
            $race = $races[$randomRaceIndex];

            Student::create([
                'user_id' => $i+1,
                'ic' => "010203101" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'student_card_no' => '22WMR' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'resident_id' => 'NFR ' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'contact_no' => "0123456789",
                'gender' => "Female",
                'race' => $race,
                'citizenship' => "Citizen",
                'address' => "6, Jalan Merah|Taman Merah|53000|Setapak|Kuala Lumpur|Malaysia",
                'emergency_contact_name' => "Lee Ah Meng",
                'emergency_contact' => "0166666666"
            ]);
        }

        //dummy data for male residents
        for($i=151; $i <= 200; $i++) {
            $races = ['Chinese', 'Malay', 'Indian'];
            $randomRaceIndex = mt_rand(0, count($races) - 1);
            $race = $races[$randomRaceIndex];

            Student::create([
                'user_id' => $i+1,
                'ic' => "010203101" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'student_card_no' => '22WMR' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'resident_id' => 'NFR ' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'contact_no' => "0123456789",
                'gender' => "Male",
                'race' => $race,
                'citizenship' => "Citizen",
                'address' => "6, Jalan Merah|Taman Merah|53000|Setapak|Kuala Lumpur|Malaysia",
                'emergency_contact_name' => "Lee Ah Meng",
                'emergency_contact' => "0166666666"
            ]);
        }
        
    }
}
