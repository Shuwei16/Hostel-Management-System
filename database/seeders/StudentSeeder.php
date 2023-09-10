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
        Student::create([
            'user_id' => 2,
            'ic' => "010203101234",
            'student_card_no' => "23WMR12345",
            'resident_id' => "NFR 12342023",
            'contact_no' => "0123456789",
            'gender' => "Female",
            'race' => "Chinese",
            'citizenship' => "Citizen",
            'address' => "6, Jalan Merah|Taman Merah|53000|Setapak|Kuala Lumpur|Malaysia",
            'emergency_contact_name' => "Lee Ah Meng",
            'emergency_contact' => "0166666666"
        ]);
    }
}
