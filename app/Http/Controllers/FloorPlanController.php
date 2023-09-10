<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Room;
use App\Models\Block;
use App\Models\Registration;
use Illuminate\Support\Carbon;

class FloorPlanController extends Controller
{
    public function showFloorPlan()
    {
        $blocks = Block::all();
        $gender = Block::where('block_id', 1)
                ->select('gender')
                ->first();
        $rooms = Room::where('block_id', 1)
                     ->where('floor', 'G')
                     ->select('room_id', 'room_code', 'occupied_slots')
                     ->get();

        return view('admin/room/roomManagement', ['selected_block' => 1, 'selected_floor' => 'G', 'blocks' => $blocks, 'gender' => $gender, 'rooms' => $rooms]);
    }

    public function filter(Request $request)
    {
        $blocks = Block::all();
        $gender = Block::where('block_id', $request->block)
                ->select('gender')
                ->first();
        $rooms = Room::where('block_id', $request->block)
                     ->where('floor', $request->floor)
                     ->select('room_id', 'room_code', 'occupied_slots')
                     ->get();

        return view('admin/room/roomManagement', ['selected_block' => $request->block, 'selected_floor' => $request->floor, 'gender' => $gender, 'blocks' => $blocks, 'rooms' => $rooms]);
    }

    public function showRoomDetails($id) 
    {
        $room = Room::where('room_id', $id)
                     ->select('room_id', 'room_code', 'block_id', 'floor', 'occupied_slots', 'race_restriction')
                     ->first();
        $block = Block::where('block_id', $room->block_id)
                      ->select('block_name', 'gender')
                      ->first();
        $residents = Registration::join('students', 'registrations.student_id', '=', 'students.student_id')
                                 ->join('users', 'students.user_id', '=', 'users.id')
                                 ->where('registrations.room_id', $id)
                                 ->whereIn('registrations.status', ['Pending Payment', 'Payment Completed', 'Checked In'])
                                 ->select('users.id as user_id',
                                          'users.name as name',
                                          'users.email as email',
                                          'registrations.registration_id as registration_id',
                                          'registrations.status as status',
                                          'students.student_id as student_id', 
                                          'students.ic as ic', 
                                          'students.resident_id as resident_id',
                                          'students.student_card_no as student_card_no',
                                          'students.contact_no as contact_no',
                                          'students.race as race',
                                          'students.address as address',
                                          'students.emergency_contact_name as emergency_name',
                                          'students.emergency_contact as emergency_contact')
                                 ->where(function ($query) {
                                      $query->whereRaw('registrations.registration_id = (
                                          SELECT MAX(registration_id)
                                          FROM registrations
                                          WHERE student_id = students.student_id
                                          AND status IN (\'Pending Payment\', \'Payment Completed\', \'Checked In\')
                                      )');
                                  })
                                 ->get();

        return view('admin/room/roomDetails', ['room' => $room, 'block' => $block, 'residents' => $residents]);
    }

    public function roomCheckIn($room_id, $user_id, $registration_id) 
    {
        // update user type as resident
        $user = User::find($user_id);
        $user->role = 1;
        $user->save();

        // generate resident id
        $currentYear = date('Y');
        $unique = false;
        $generatedResidentId = '';

        do {
            $randomPart = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $candidateId = "NFR " . $randomPart . $currentYear;
            
            $existingResident = Student::where('resident_id', $candidateId)->first();
        
            if (!$existingResident) {
                $unique = true;
                $generatedResidentId = $candidateId;
            }
        } while (!$unique);

        // assign generated resident id
        $student = Student::where('user_id', $user_id)->first();
        $student->resident_id = $generatedResidentId;
        $student->save();

        // update registration status as "Checked In"
        $registration = Registration::find($registration_id);
        $registration->status = "Checked In";
        $registration->check_in_date = now();
        $registration->save();

        return redirect(route('admin-roomDetails', ['id'=>$room_id]))->with("success", "Room checked in successfuly!");
    }

    public function roomCheckOut($room_id, $user_id, $registration_id) 
    {
        // update user type as non resident
        $user = User::find($user_id);
        $user->role = 0;
        $user->save();

        // remove resident id
        $student = Student::where('user_id', $user_id)->first();
        $student->resident_id = "";
        $student->save();

        // update registration status as "Checked Out"
        $registration = Registration::find($registration_id);
        $registration->status = "Checked Out";
        $registration->check_out_date = now();
        $registration->save();

        // get assigned room
        $room = Room::find($registration->room_id);
        // remove room asignment
        $room->occupied_slots--; // Decrement occupied_slots
        if ($room->occupied_slots === 0) {
            $room->race_restriction = "none"; // Set race_restriction to "none" if occupied_slots becomes 0
        }

        return redirect(route('admin-roomDetails', ['id'=>$room_id]))->with("success", "Room checked out successfuly!");
    }
}
