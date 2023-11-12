<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Student;
use App\Models\User;
use App\Models\Registration;
use App\Models\Room;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();

        $profileInfo = User::where('user_id', $user->id)
                     ->join('students', 'students.user_id', '=', 'users.id')
                     ->join('registrations', 'registrations.student_id', '=', 'students.student_id')
                     ->join('rooms', 'rooms.room_id', 'registrations.room_id')
                     ->select('users.name as name',
                              'users.email as email',
                              'students.ic as ic',
                              'students.student_card_no as student_card_no',
                              'students.resident_id as resident_id',
                              'students.contact_no as contact_no',
                              'students.gender as gender',
                              'students.race as race',
                              'students.citizenship as citizenship',
                              'students.address as address',
                              'students.emergency_contact_name as emergency_contact_name',
                              'students.emergency_contact as emergency_contact',
                              'rooms.room_code')
                     ->first();
        
        $address = explode('|', $profileInfo->address);
        $contact_no = substr_replace($profileInfo->contact_no, '-', 3, 0);
        $emergency_contact_no = substr_replace($profileInfo->emergency_contact, '-', 3, 0);

        $photoPath = public_path('labels/' . $profileInfo->resident_id . ' ' . $profileInfo->name);
        $photoExist = false;
        if (File::exists($photoPath)) {
            $photoExist = true;
        }

        return view('resident/profile/profile', compact('profileInfo', 'address', 'contact_no', 'emergency_contact_no', 'photoExist'));
    }

    public function editProfile()
    {
        $user = auth()->user();

        $profileInfo = User::where('user_id', $user->id)
                     ->join('students', 'students.user_id', '=', 'users.id')
                     ->join('registrations', 'registrations.student_id', '=', 'students.student_id')
                     ->join('rooms', 'rooms.room_id', 'registrations.room_id')
                     ->select('students.student_card_no as student_card_no',
                              'students.contact_no as contact_no',
                              'students.address as address',
                              'students.emergency_contact_name as emergency_contact_name',
                              'students.emergency_contact as emergency_contact')
                     ->first();
        
        $address = explode('|', $profileInfo->address);

        return view('resident/profile/editProfile', compact('profileInfo', 'address'));
    }

    public function editProfilePost(Request $request)
    {
        $user = auth()->user();

        $student = Student::where('user_id', $user->id)->first();
        $student->update([
            'student_card_no' => $request->student_card_no,
            'contact_no' => $request->contact_no,
            'address' => $request->address_line_1 . "|" . $request->address_line_2 . "|" . $request->postcode . "|" . $request->city . "|" . $request->state . "|" . $request->country,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact' => $request->emergency_contact_no
        ]);

        return redirect(route('resident-profile'))->with("success", "Your information is updated successfully!");
    }
}
