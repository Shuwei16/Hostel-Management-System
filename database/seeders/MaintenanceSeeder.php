<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaintenanceSlot;
use App\Models\MaintenanceBooking;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the current date
        $currentDate = now();
        // Calculate the date for the next Monday
        $nextMondayDate = $currentDate->addDays(7)->startOfWeek();
        // Calculate the date for the next Friday
        $nextFridayDate = $nextMondayDate->copy()->addDays(4);

        $dates = [];
        // Store all next week's dates
        for ($date = $nextMondayDate; $date->lte($nextFridayDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }
        // Store all times
        $times = ["09:00:00", "10:00:00", "11:00:00", "14:00:00", "15:00:00", "16:00:00"];

        foreach ($dates as $date) {
            foreach ($times as $time) {
                // Create a new record for each day and save it to the database
                $newSlot = new MaintenanceSlot();
                $newSlot->date = $date;
                // Set other attributes for the record as needed
                $newSlot->time = $time;
                $newSlot->status = 1; //1-available, 0-booked

                // Save the new record to the database
                $newSlot->save();
            }
        }

        //dummy data for maintenance booking record
        for($i=1; $i <= 15; $i++) {

            MaintenanceBooking::create([
                'slot_id' => $i,
                'student_id' => rand(1, 5),
                'maintenance_type' => "Light Bulb Replacement",
                'description' => "Some description..",
                'status' => "Applied",
            ]);

            MaintenanceSlot::find($i)
                           ->update(['status' => '0']);
        }
    }
}
