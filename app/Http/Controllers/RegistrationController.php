<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Block;
use Illuminate\Support\Carbon;

class RegistrationController extends Controller
{

    /*Student side*/
    //new registration
    public function newRegistration()
    {
        $currentDate = Carbon::today();
        $registration = null;
        $availability = true;

        // get semester
        $semester = Semester::whereDate('new_reg_open_date', '<=' , $currentDate)
                            ->whereDate('new_reg_close_date', '>=', $currentDate)
                            ->select('semester_id','semester_name', 'start_date', 'end_date', 'price')
                            ->first();

        if ($semester !== null) {
            // check whether have registered
            $student = Student::where('user_id', auth()->id())
                              ->select('student_id')
                              ->first();

            if ($student !== null) {
            $registration = Registration::where('student_id', $student->student_id)
                                ->where('semester_id', $semester->semester_id)
                                ->select('registration_id', 'status')
                                ->orderby('registration_id', 'desc')
                                ->first();
            }

            // check rooms availability
            $availableRooms = Room::where('occupied_slots', '<', 2)
                        ->select('room_id')
                        ->first();
            if(!$availableRooms) {
            $availability = false;
            }
        }

        return view('non-resident/new', compact('registration','semester', 'availability'));
    }

    //submit new registration
    public function submitNewRegistration(Request $request)
    {
        // save new registration
        $request->validate([
            'ic' => 'required',
            'student_card_no' => 'required',
            'contact_no' => 'required',
            'gender' => 'required|in:Male,Female',
            'race' => 'required|in:Chinese,Malay,Indian,Other',
            'citizenship' => 'required|in:Citizen,Non-citizen'
        ]);

        // find available rooms
        $blocks = Block::where('gender', $request->gender)
                       ->select('block_id')
                       ->orderBy('block_id', 'desc')
                       ->get();

        if($request->has('share_race')) { // share room with different race
            foreach ($blocks as $block) {
                $availableRooms = Room::where('block_id', $block->block_id)
                               ->where('occupied_slots', '<', 2) //the room is empty or still available for 1 people
                               ->whereIn('race_restriction', ['none']) //find roommate with same race
                               ->select('room_id', 'room_code', 'occupied_slots', 'race_restriction')
                               ->orderBy('room_id', 'asc')
                               ->get();
            }
        } else { // share room with same race only
            foreach ($blocks as $block) {
                $availableRooms = Room::where('block_id', $block->block_id)
                               ->where('occupied_slots', '<', 2) //the room is empty or still available for 1 people
                               ->whereIn('race_restriction', [$request->race, 'none']) //find roommate with same race
                               ->select('room_id', 'room_code', 'occupied_slots', 'race_restriction')
                               ->orderBy('room_id', 'asc')
                               ->get();
            }
        }

        $room = $availableRooms->first();

         // check whether student info exist in db
         $student = Student::where('user_id', auth()->id())
         ->select('student_id')
         ->first();

         
        if($student === null) {
            // store student info
            $student_data['user_id'] = $request->user_id;
            $student_data['ic'] = $request->ic;
            $student_data['student_card_no'] = $request->student_card_no;
            $student_data['contact_no'] = $request->contact_no;
            $student_data['gender'] = $request->gender;
            $student_data['race'] = $request->race;
            $student_data['citizenship'] = $request->citizenship;
            $student = Student::create($student_data);
        } else {
            // update student info
            $student->ic = $request->ic;
            $student->student_card_no = $request->student_card_no;
            $student->contact_no = $request->contact_no;
            $student->gender = $request->gender;
            $student->race = $request->race;
            $student->citizenship = $request->citizenship;
            $student->save();
        }

        // store registration info
        $registration_data['student_id'] = $student->student_id;
        $registration_data['semester_id'] = $request->semester_id;
        $registration_data['registration_type'] = "New Resident";

        $currentDate = Carbon::today();

        $registration_data['withdrawal_due_date'] = Carbon::parse($currentDate)->addWeek();
        $registration_data['payment_due_date'] = Carbon::parse($currentDate)->addWeek();

        // found suitable room
        if($room) {
            // assign room
            $registration_data['room_id'] = $room->room_id;
            $registration_data['status'] = "Pending Payment";
            
            // update room status
            $room->occupied_slots++;
            if(!$request->has('share_race')) {
                $room->race_restriction =  $request->race;
            }

            // save data
            $room->save();
            $registration = Registration::create($registration_data);

            return redirect(route('non-resident-approval', ['id'=>$registration->registration_id]))->with("success", "Registration Success! A room is assign to you! You are required to make payment to complete the registration.");

        } else {
            // return fail
            $registration_data['status'] = "Failed";
            $registration = Registration::create($registration_data);

            return redirect(route('non-resident-approval', ['id'=>$registration->registration_id]))->with("error", "Sorry, there are no suitable room for you. This may because of room that suit to your gender or race are fully occupied. You may try to register again after if there are any updates due to other's cancellation.");
        }
    }

    //view registration history
    public function history()
    {
        // get student
        $student = Student::where('user_id', auth()->id())
                          ->select('student_id')
                          ->first();
        if ($student === null) {
            $registrations = null;
        } else {
            // get registration history
            $registrations = Registration::join('semesters', 'registrations.semester_id', '=', 'semesters.semester_id')
                                         ->where('student_id', $student->student_id)
                                         ->select('registrations.registration_id as registration_id', 
                                                  'registrations.status as status', 
                                                  'registrations.created_at as registration_date', 
                                                  'semesters.semester_name as semester_name', 
                                                  'semesters.start_date as start_date', 
                                                  'semesters.end_date as end_date',
                                                  'semesters.price as price')
                                         ->orderBy('registrations.registration_id', 'desc')
                                         ->paginate(10);
        }

        if(auth()->user()->role === 0) {
            return view('non-resident/history', ['registrations' => $registrations]);
        } else {
            return view('resident/hostel-registration/registrationHistory', ['registrations' => $registrations]);
        }
        
    }

    //display registration approval details
    public function showApprovalDetails($id)
    {
        $currentDate = Carbon::today();

        // get registration details
        $registration = Registration::join('semesters', 'registrations.semester_id', '=', 'semesters.semester_id')
                                     ->leftjoin('rooms', 'registrations.room_id', '=', 'rooms.room_id')
                                     ->leftjoin('payments', 'registrations.registration_id', '=', 'payments.registration_id')
                                     ->select('registrations.registration_id as registration_id', 
                                              'registrations.status as status', 
                                              'registrations.registration_type as registration_type', 
                                              'registrations.created_at as registration_date', 
                                              'registrations.withdrawal_due_date as withdrawal_due_date', 
                                              'registrations.payment_due_date as payment_due_date', 
                                              'registrations.check_in_date as check_in_date', 
                                              'registrations.check_out_date as check_out_date', 
                                              'semesters.semester_name as semester_name', 
                                              'semesters.start_date as start_date', 
                                              'semesters.end_date as end_date', 
                                              'semesters.price as price', 
                                              'rooms.room_id as room_id',
                                              'rooms.room_code as room_code',
                                              'payments.payment_id as payment_id',
                                              'payments.created_at as payment_date',)
                                     ->where('registrations.registration_id', $id)
                                     ->first();

        //check payment due date
        if($registration->status == "Pending Payment" && $currentDate > $registration->payment_due_date) {

            // get assigned room
            $room = Room::find($registration->room_id);
            
            // remove room asignment
            $room->occupied_slots--; // Decrement occupied_slots

            if ($room->occupied_slots === 0) {
                $room->race_restriction = "none"; // Set race_restriction to "none" if occupied_slots becomes 0
            }

            // update registration status
            $registration->status = "Payment Failed";

            // save updates
            $room->save();
            $registration->save();
        }

        //check withdrawal due date
        if($registration->withdrawal_due_date <= $currentDate){
            $withdrawAvailability = false;
        } else {
            $withdrawAvailability = true;
        }

        if(auth()->user()->role === 0) {
            return view('non-resident/approval', compact('registration', 'withdrawAvailability'));
        } else {
            return view('resident/hostel-registration/registrationDetails', compact('registration', 'withdrawAvailability'));
        }
    }

    //cancel registration approval
    public function cancelRegistration($id)
    {

        // get registration details
        $registration = Registration::where('registration_id', $id)
                      ->select('registration_id', 'room_id', 'status')
                      ->first();

        // get assigned room
        $room = Room::find($registration->room_id);
        

        // remove room asignment
        $room->occupied_slots--; // Decrement occupied_slots

        if ($room->occupied_slots === 0) {
            $room->race_restriction = "none"; // Set race_restriction to "none" if occupied_slots becomes 0
        }

        // update registration status
        $registration->status = "Canceled";

        // save updates
        $room->save();
        $registration->save();

        return redirect(route('non-resident-approval', ['id'=>$registration->registration_id]))->with("success", "Registration Canceled!");
    }

    //extension registration
    public function extensionRegistration()
    {
        $currentDate = Carbon::today();
        $registration = null;
        $student = null;

        // get semester
        $semester = Semester::whereDate('extension_reg_open_date', '<=' , $currentDate)
                            ->whereDate('extension_reg_close_date', '>=', $currentDate)
                            ->select('semester_id','semester_name', 'start_date', 'end_date', 'price')
                            ->first();

        if ($semester !== null) {
            // get student id
            $student = Student::where('user_id', auth()->id())
                              ->join('registrations', 'registrations.student_id', '=', 'students.student_id')
                              ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                              ->select('students.student_id as student_id', 
                                       'students.ic as ic', 
                                       'students.contact_no as contact_no',
                                       'rooms.room_id as room_id',
                                       'rooms.room_code as room_code')
                              ->first();

            $registration = Registration::where('student_id', $student->student_id)
                          ->where('semester_id', $semester->semester_id)
                          ->select('registration_id', 'status')
                          ->orderby('registration_id', 'desc')
                          ->first();
        }

        return view('resident/hostel-registration/extensionRegistration', compact('registration','semester', 'student'));
    }

    //submit extension registration
    public function submitExtensionRegistration(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'semester_id' => 'required',
            'contact_no' => 'required'
        ]);

        // save updated contact no
        $student = Student::find($request->student_id);
        $student->update(['contact_no' => $request->contact_no]);

         // store registration info
         $registration_data['student_id'] = $request->student_id;
         $registration_data['semester_id'] = $request->semester_id;
         $registration_data['registration_type'] = "Current Resident";
 
         $currentDate = Carbon::today();
 
         $registration_data['withdrawal_due_date'] = Carbon::parse($currentDate)->addWeek();
         $registration_data['payment_due_date'] = Carbon::parse($currentDate)->addWeek();

         $registration_data['room_id'] = $request->room_id;
         $registration_data['status'] = "Pending Payment";
         $registration = Registration::create($registration_data);

         return redirect(route('resident-registrationDetails', ['id'=>$registration->registration_id]))->with("success", "Registration Success! A room is assign to you! You are required to make payment to complete the registration.");
    }

    /*Admin side*/
    //display list of registrations
    public function showAllRegistrations()
    {
        // get all registrations
        $registrations = Registration::join('semesters', 'registrations.semester_id', '=', 'semesters.semester_id')
                                         ->join('students', 'registrations.student_id', '=', 'students.student_id')
                                         ->join('users', 'students.user_id', '=', 'users.id')
                                         ->select('registrations.registration_id as registration_id', 
                                                  'registrations.status as status', 
                                                  'registrations.created_at as registration_date', 
                                                  'registrations.registration_type as registration_type',
                                                  'semesters.semester_name as semester_name', 
                                                  'semesters.start_date as start_date', 
                                                  'users.name as name')
                                         ->orderBy('registrations.registration_id', 'desc')
                                         ->paginate(10);

        return view('admin/hostel-registration/registrationRecord', compact('registrations'));
    }

    //display registration details
    public function showRegistrationDetails($id)
    {
        // get registration details
        $registration = Registration::join('semesters', 'registrations.semester_id', '=', 'semesters.semester_id')
                                    ->join('students', 'registrations.student_id', '=', 'students.student_id')
                                    ->join('users', 'students.user_id', '=', 'users.id')
                                    ->leftjoin('rooms', 'registrations.room_id', '=', 'rooms.room_id')
                                    ->leftjoin('payments', 'payments.registration_id', '=', 'registrations.registration_id')
                                    ->select('registrations.registration_id as registration_id', 
                                            'registrations.status as status', 
                                            'registrations.created_at as registration_date', 
                                            'registrations.registration_type as registration_type', 
                                            'registrations.check_in_date as check_in_date', 
                                            'registrations.check_out_date as check_out_date', 
                                            'semesters.semester_name as semester_name', 
                                            'students.student_card_no as student_card_no', 
                                            'students.contact_no as contact_no', 
                                            'users.name as name', 
                                            'users.email as email', 
                                            'rooms.room_code as room_code',
                                            'payments.created_at as payment_date')
                                    ->where('registrations.registration_id', $id)
                                    ->first();

        return view('admin/hostel-registration/registrationDetails', compact('registration'));
    }

    //display all semester records for application
    public function showAllSemesters()
    {
        $semesters = Semester::orderBy('semester_id', 'desc')
                             ->paginate(10);

        return view('admin/hostel-registration/semester', compact('semesters'));
    }

    //display semester details
    public function showSemesterDetails($id)
    {
        // get semester details
        $semester = Semester::where('semester_id', $id)
                            ->first();

        return view('admin/hostel-registration/semesterDetails', compact('semester'));
    }


    //add new semester
    public function addSemester()
    {
        return view('admin/hostel-registration/addSemester');
    }

    //submit add new semester
    public function addSemesterPost(Request $request)
    {
        $lastSem = Semester::orderBy('semester_id', 'desc')
                 ->first();

        // save new semester
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'start_date' => 'required|date|after:' . $lastSem->end_date, //must after the end date of previous semester
            'end_date' => 'required|date|after:start_date',
            'price' => 'required'
        ]);

        // store semester info
        $semester_data['semester_name'] = $request->month . " " . $request->year;
        $semester_data['start_date'] = $request->start_date;
        $semester_data['end_date'] = $request->end_date;
        $semester_data['price'] = $request->price;
        //earliest check in date = start date
        $semester_data['earliest_check_in_date'] = $request->start_date;
        //latest check out date = end date
        $semester_data['latest_check_out_date'] = $request->end_date;
        //new registration open date = 1 months before start date
        $semester_data['new_reg_open_date'] = Carbon::parse($request->start_date)->subMonth();
        //extention registration open date = 2 months before start date
        $semester_data['extension_reg_open_date'] = Carbon::parse($request->start_date)->subMonths(2);
        //new registration close date = 1 months before end date
        $semester_data['new_reg_close_date'] = Carbon::parse($request->end_date)->subMonth();
        //extension registration close date = 1 day before new registration end date
        $semester_data['extension_reg_close_date'] = Carbon::parse($semester_data['new_reg_open_date'])->subDay();
        $semester = Semester::create($semester_data);

        return redirect(route('admin-semesters'))->with("success", "Semester added successfully!");
    }

    //edit semester
    public function editSemester($id)
    {
        // get semester details
        $semester = Semester::find($id);
        $semester_name = explode(" ", $semester->semester_name);
        $month = $semester_name[0];
        $year = $semester_name[1];

        return view('admin/hostel-registration/editSemester', compact('semester', 'month', 'year'));
    }

    //submit edit semester
    public function editSemesterPost(Request $request, $id)
    {
        $lastSem = Semester::orderBy('semester_id', 'desc')
                 ->first();

        // save new semester
        $request->validate([
            'start_date' => 'after:' . $lastSem->end_date, //must after the end date of previous semester=
        ]);

        $semester = Semester::find($id);
        // update semester info
        if($request->start_date == null) {
            $request->start_date = $semester->start_date;
        }

        if($request->end_date == null) {
            $request->end_date = $semester->end_date;
        }

        $semester->update(['semester_name' => $request->month . " " . $request->year,
                           'price' => $request->price,
                           'start_date' => $request->start_date,
                           'end_date' => $request->end_date,
                           'withdrawal_date' => Carbon::parse($request->start_date)->addWeek(),
                           'payment_due_date' => Carbon::parse($request->start_date)->addWeek(),
                           'earliest_check_in_date' => $request->start_date,
                           'latest_check_out_date' => $request->end_date,
                           'new_reg_open_date' => Carbon::parse($request->start_date)->subMonth(),
                           'extension_reg_open_date' => Carbon::parse($request->start_date)->subMonths(2),
                           'new_reg_close_date' => Carbon::parse($request->end_date)->subMonth(),
                           'extension_reg_close_date' => Carbon::parse($request->start_date)->subMonth()->subDay()
                         ]);
        $semester->update(['price' => $request->price]);

        return redirect(route('admin-viewSemester', ['id'=>$semester->semester_id]))->with("success", "Semester has been updated!");
    }

    //delete semester
    public function deleteSemester($id)
    {
        $semester = Semester::find($id);
        $semester->delete();
        return redirect(route('admin-semesters'))->with("success", "Semester deleted!");
    }
}
