<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceBooking;
use App\Models\MaintenanceSlot;
use App\Models\Student;

class MaintenanceController extends Controller
{
    // Display add maintenance booking page
    public function addMaintenance()
    {
        // Get the current date
        $currentDate = now();
        // Calculate the date for the next Monday
        $nextMondayDate = $currentDate->addDays(7)->startOfWeek();
        // Calculate the date for the next Friday
        $nextFridayDate = $nextMondayDate->copy()->addDays(4);
        // Check if maintainance time slots for the entire next week (from Monday to Friday) already exist
        $existingSlots = MaintenanceSlot::whereBetween('date', [$nextMondayDate->toDateString(), $nextFridayDate->toDateString()])->get();

        $dates = [];
        // Store all next week's dates
        for ($date = $nextMondayDate; $date->lte($nextFridayDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }
        // Store all times
        $times = ["09:00:00", "10:00:00", "11:00:00", "14:00:00", "15:00:00", "16:00:00"];

        if ($existingSlots->isEmpty()) {
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
        }

        // Get all slots
        $slots = MaintenanceSlot::where('date', $dates[0])->get();

        return view('resident/room-maintenance/addMaintenance', ['selected_date' => $dates[0], 'dates' => $dates, 'slots' => $slots]);
    }

    // Submit maintanance booking
    public function addMaintenancePost(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'selected_slot' => 'required',
            'maintenance_type' => 'required',
            'description' => 'required',
        ]);

        // get student
        $student = Student::where('user_id', '=', auth()->id())->first();

        // new maintenance booking
        MaintenanceBooking::create([
            'slot_id' => $request->selected_slot,
            'student_id' => $student->student_id,
            'maintenance_type' => $request->maintenance_type,
            'description' => $request->description,
            'status' => "Applied",
        ]);

        // update slot status
        MaintenanceSlot::where('slot_id', $request->selected_slot)
                       ->update(['status' => '0']);

        return redirect(route('resident-maintenance'))->with("success", "Your room maintenance has been booked successfully!");
    }

    // Change slots selection based on selected date
    public function addMaintenanceGet(Request $request)
    {
            // Get the current date
            $currentDate = now();
            // Calculate the date for the next Monday
            $nextMondayDate = $currentDate->addDays(7)->startOfWeek();
            // Calculate the date for the next Friday
            $nextFridayDate = $nextMondayDate->copy()->addDays(4);
            // Check if maintainance time slots for the entire next week (from Monday to Friday) already exist
            $existingSlots = MaintenanceSlot::whereBetween('date', [$nextMondayDate->toDateString(), $nextFridayDate->toDateString()])->get();

            $dates = [];
            // Store all next week's dates
            for ($date = $nextMondayDate; $date->lte($nextFridayDate); $date->addDay()) {
                $dates[] = $date->toDateString();
            }

            // Get all slots
            $slots = MaintenanceSlot::where('date', '=', $request->date)->get();

            return view('resident/room-maintenance/addMaintenance', ['selected_date' => $request->date, 'dates' => $dates, 'slots' => $slots]);
    }

    // Display maintenance booking list for a resident
    public function residentMaintenanceList() {
        // get student
        $student = Student::where('user_id', '=', auth()->id())->first();

        $maintenances = MaintenanceBooking::where('student_id', '=', $student->student_id)
                                          ->join('maintenance_slots', 'maintenance_slots.slot_id', '=', 'maintenance_bookings.slot_id')
                                          ->select('maintenance_bookings.maintenance_booking_id as maintenance_booking_id',
                                                   'maintenance_slots.date as date',
                                                   'maintenance_slots.time as time',
                                                   'maintenance_bookings.maintenance_type as maintenance_type',
                                                   'maintenance_bookings.created_at as applied_date',
                                                   'maintenance_bookings.status as status')
                                          ->orderby('maintenance_booking_id', 'desc')
                                          ->get();

        return view('resident/room-maintenance/maintenance', ['maintenances' => $maintenances]);
    }

    // Display maintenance details for resident
    public function residentMaintenanceDetails($id) {

        $maintenance = MaintenanceBooking::where('maintenance_booking_id', '=', $id)
                                         ->join('maintenance_slots', 'maintenance_slots.slot_id', '=', 'maintenance_bookings.slot_id')
                                         ->select('maintenance_bookings.maintenance_booking_id as maintenance_booking_id',
                                                   'maintenance_slots.date as date',
                                                   'maintenance_slots.time as time',
                                                   'maintenance_bookings.maintenance_type as maintenance_type',
                                                   'maintenance_bookings.description as description',
                                                   'maintenance_bookings.created_at as applied_date',
                                                   'maintenance_bookings.status as status')
                                          ->first();

        return view('resident/room-maintenance/maintenanceDetails', compact('maintenance'));
    }

    public function cancelMaintenance($id) {

        MaintenanceBooking::where('maintenance_booking_id', '=', $id)
                          ->update(['status' => 'Canceled']);

        return redirect(route('resident-maintenanceDetails', ['id' => $id]))->with("success", "Your room maintenance has been canceled successfully!");
    }

    // Display today's maintenance task for admin
    public function todaysMaintenances() {

        $maintenances = MaintenanceBooking::join('maintenance_slots', 'maintenance_slots.slot_id', '=', 'maintenance_bookings.slot_id')
                                          ->join('students', 'students.student_id', '=', 'maintenance_bookings.student_id')
                                          ->join('users', 'users.id', '=', 'students.user_id')
                                          ->join('registrations', function ($join) {
                                             $join->on('students.student_id', '=', 'registrations.student_id')
                                                 ->whereRaw('registrations.registration_id = (SELECT MAX(registration_id) FROM registrations WHERE student_id = students.student_id)');
                                          })
                                          ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                                          ->whereDate('maintenance_slots.date', now()->toDateString())
                                          ->select('maintenance_bookings.maintenance_booking_id as maintenance_booking_id',
                                                   'maintenance_slots.date as date',
                                                   'maintenance_slots.time as time',
                                                   'rooms.room_code as room_code',
                                                   'users.name as resident_name',
                                                   'maintenance_bookings.maintenance_type as maintenance_type',
                                                   'maintenance_bookings.status as status')
                                          ->orderby('maintenance_booking_id', 'desc')
                                          ->get();

        return view('admin/room-maintenance/todaysMaintenance', ['maintenances' => $maintenances]);
    }

    // Display all maintenance task for admin
    public function allMaintenances() {

        $maintenances = MaintenanceBooking::join('maintenance_slots', 'maintenance_slots.slot_id', '=', 'maintenance_bookings.slot_id')
                                          ->join('students', 'students.student_id', '=', 'maintenance_bookings.student_id')
                                          ->join('users', 'users.id', '=', 'students.user_id')
                                          ->join('registrations', function ($join) {
                                             $join->on('students.student_id', '=', 'registrations.student_id')
                                                 ->whereRaw('registrations.registration_id = (SELECT MAX(registration_id) FROM registrations WHERE student_id = students.student_id)');
                                          })
                                          ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                                          ->select('maintenance_bookings.maintenance_booking_id as maintenance_booking_id',
                                                   'maintenance_slots.date as date',
                                                   'maintenance_slots.time as time',
                                                   'rooms.room_code as room_code',
                                                   'users.name as resident_name',
                                                   'maintenance_bookings.maintenance_type as maintenance_type',
                                                   'maintenance_bookings.status as status')
                                          ->orderby('maintenance_booking_id', 'desc')
                                          ->get();

        return view('admin/room-maintenance/allMaintenances', ['maintenances' => $maintenances]);
    }

    // Display maintenance details for admin
    public function adminMaintenanceDetails($id) {
        $maintenance = MaintenanceBooking::where('maintenance_booking_id', '=', $id)
                                          ->join('maintenance_slots', 'maintenance_slots.slot_id', '=', 'maintenance_bookings.slot_id')
                                          ->join('students', 'students.student_id', '=', 'maintenance_bookings.student_id')
                                          ->join('users', 'users.id', '=', 'students.user_id')
                                          ->join('registrations', function ($join) {
                                             $join->on('students.student_id', '=', 'registrations.student_id')
                                                 ->whereRaw('registrations.registration_id = (SELECT MAX(registration_id) FROM registrations WHERE student_id = students.student_id)');
                                          })
                                          ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                                          ->select('maintenance_bookings.maintenance_booking_id as maintenance_booking_id',
                                                   'maintenance_bookings.created_at as applied_date',
                                                   'rooms.room_code as room_code',
                                                   'users.name as resident_name',
                                                   'students.resident_id as resident_id',
                                                   'maintenance_slots.date as date',
                                                   'maintenance_slots.time as time',
                                                   'maintenance_bookings.maintenance_type as maintenance_type',
                                                   'maintenance_bookings.description as description',
                                                   'maintenance_bookings.status as status')
                                          ->first();

        return view('admin/room-maintenance/maintenanceDetails', compact('maintenance'));
    }

    public function doneMaintenance($id) {

        MaintenanceBooking::where('maintenance_booking_id', '=', $id)
                          ->update(['status' => 'Completed']);

        return redirect(route('admin-maintenanceDetails', ['id' => $id]))->with("success", "This maintenance is completed!");
    }
}
