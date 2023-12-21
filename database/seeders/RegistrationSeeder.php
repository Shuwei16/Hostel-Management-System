<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Registration;
use App\Models\Room;
use Illuminate\Support\Carbon;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Carbon::today();
        
        $room_id = 0;
        //dummy data for 150 female registration records
        for($i=1; $i <= 150; $i++) {

            if($i % 2 != 0) {
                $room_id++;
            }

            if($i == 1) {
                Registration::create([
                    'student_id' => $i,
                    'semester_id' => 1,
                    'room_id' => $room_id,
                    'registration_type' => "New Resident",
                    'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'check_in_date' => now(),
                    'status' => "Payment Completed"
                ]);
            } else {
                Registration::create([
                    'student_id' => $i,
                    'semester_id' => 1,
                    'room_id' => $room_id,
                    'registration_type' => "New Resident",
                    'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'check_in_date' => now(),
                    'status' => "Checked In"
                ]);
            }

            for($j=2; $j <= 4; $j++) {
                Registration::create([
                    'student_id' => $i,
                    'semester_id' => $j,
                    'room_id' => $room_id,
                    'registration_type' => "Current Resident",
                    'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'check_in_date' => now(),
                    'status' => "Extended"
                ]);
            }

            $room = Room::find($room_id);
            $room->update(['occupied_slots' => $room->occupied_slots+1]);
        }

        $room_id = 700; //male's room id starting at 701
        //dummy data for 150 male registration records
        for($i=151; $i <= 200; $i++) {

            if($i % 2 != 0) {
                $room_id++;
            }

            if($i == 151) {
                Registration::create([
                    'student_id' => $i,
                    'semester_id' => 1,
                    'room_id' => $room_id,
                    'registration_type' => "New Resident",
                    'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'check_in_date' => now(),
                    'status' => "Payment Completed"
                ]);
            } else {
                Registration::create([
                    'student_id' => $i,
                    'semester_id' => 1,
                    'room_id' => $room_id,
                    'registration_type' => "New Resident",
                    'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'check_in_date' => now(),
                    'status' => "Checked In"
                ]);
            }

            for($j=2; $j <= 4; $j++) {
                Registration::create([
                    'student_id' => $i,
                    'semester_id' => $j,
                    'room_id' => $room_id, 
                    'registration_type' => "Current Resident",
                    'payment_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'withdrawal_due_date' => Carbon::parse($currentDate)->addWeek(),
                    'check_in_date' => now(),
                    'status' => "Extended"
                ]);
            }

            $room = Room::find($room_id);
            $room->update(['occupied_slots' => $room->occupied_slots+1]);
        }
    }
}
