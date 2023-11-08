<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitorRegistration;
use App\Models\Student;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class VisitorController extends Controller
{
    function addVisitorRegistration() {
        return view('resident/visitor-registration/addVisitorRegistration');
    }

    function addVisitorRegistrationPost(Request $request) {
        $request->validate([
            'visitor_name' => 'required',
            'visit_purpose' => 'required',
            'visit_date' => 'required',
            'visit_time' => 'required',
            'duration' => 'required',
        ]);

        $student = Student::where('user_id', '=', auth()->id())->first();

        $visitor = VisitorRegistration::create([
            'student_id' => $student->student_id,
            'visitor_name' => $request->visitor_name,
            'visit_purpose' => $request->visit_purpose,
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'duration' => $request->duration,
            'status' => 'Pending Approval',
        ]);

        $directoryPath = public_path('images/visitorQR');

        // Generate a QR code
        $qrCode = QrCode::format('svg')->size(200)->generate($visitor->visitor_reg_id);

        // Store the QR code
        $directoryPath = public_path('images/visitorQR');
        $fileName = 'visitor_' . time() . '.svg';
        File::put($directoryPath . '/' . $fileName, $qrCode);

        // Save QR code in db
        $visitor->update(['qr_code' => $fileName]);

        return view('resident/visitor-registration/addVisitorRegistration')->with('success', 'Your visitor has been registered successfully! Please wait for the approval.');
    }

    function visitorRegistrationList() {
        //display for resident
        if(auth()->user()->role == 1) {
            $registrations = VisitorRegistration::join('students', 'students.student_id', '=', 'visitor_registrations.student_id')
                                                ->where('students.user_id', '=', auth()->id())
                                                ->select('visitor_registrations.visitor_reg_id as visitor_reg_id',
                                                         'visitor_registrations.visitor_name as visitor_name',
                                                         'visitor_registrations.visit_date as visit_date',
                                                         'visitor_registrations.visit_time as visit_time',
                                                         'visitor_registrations.duration as duration',
                                                         'visitor_registrations.created_at as applied_date',
                                                         'visitor_registrations.status as status',)
                                                ->orderBy('visitor_registrations.visitor_reg_id', 'desc')
                                                ->paginate(10);
        }
        return view('resident/visitor-registration/visitorRegistration', ['registrations' => $registrations]);
    }

    function visitorRegistrationDetails($id) {
        //display for resident
        if(auth()->user()->role == 1) {
            $registration = VisitorRegistration::join('students', 'students.student_id', '=', 'visitor_registrations.student_id')
                                                ->where('visitor_registrations.visitor_reg_id', '=', $id)
                                                ->select('visitor_registrations.visitor_reg_id as visitor_reg_id',
                                                         'visitor_registrations.created_at as applied_date',
                                                         'visitor_registrations.visitor_name as visitor_name',
                                                         'visitor_registrations.visit_purpose as visit_purpose',
                                                         'visitor_registrations.visit_date as visit_date',
                                                         'visitor_registrations.visit_time as visit_time',
                                                         'visitor_registrations.duration as duration',
                                                         'visitor_registrations.status as status',
                                                         'visitor_registrations.qr_code as qr_code',)
                                                ->orderBy('visitor_registrations.visitor_reg_id', 'desc')
                                                ->first();

            return view('resident/visitor-registration/visitorRegistrationDetails', compact('registration'));
        }
    }

    public function cancelVisitorRegistration($id) {

        VisitorRegistration::find($id)
                          ->update(['status' => 'Canceled']);

        return redirect(route('resident-visitorRegistrationDetails', ['id' => $id]))->with("success", "Your visitor registration has been canceled successfully!");
    }
}
