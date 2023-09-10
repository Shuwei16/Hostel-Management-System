<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Registration;
use Illuminate\Support\Carbon;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Carbon::today();

        Registration::create([
            'student_id' => 1,
            'semester_id' => 1,
            'room_id' => 1,
            'registration_type' => "New Resident",
            'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
            'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
            'check_in_date' => now(),
            'status' => "Checked In"
        ]);
    }
}
