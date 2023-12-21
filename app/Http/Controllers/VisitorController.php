<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitorRegistration;
use App\Models\Visit;
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

        return redirect(route('resident-visitorRegistrationDetails', ['id'=>$visitor->visitor_reg_id]))->with("success", "Your visitor has been registered successfully! Please wait for the approval.");
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
            
            return view('resident/visitor-registration/visitorRegistration', ['registrations' => $registrations]);
        } else {
            $registrations = VisitorRegistration::join('students', 'students.student_id', '=', 'visitor_registrations.student_id')
                                                ->join('users', 'users.id', '=', 'students.user_id')
                                                ->select('visitor_registrations.visitor_reg_id as visitor_reg_id',
                                                         'visitor_registrations.visitor_name as visitor_name',
                                                         'visitor_registrations.visit_date as visit_date',
                                                         'visitor_registrations.visit_time as visit_time',
                                                         'visitor_registrations.duration as duration',
                                                         'users.name as resident_name',
                                                         'visitor_registrations.status as status',)
                                                ->orderBy('visitor_registrations.visitor_reg_id', 'desc')
                                                ->paginate(10);

            return view('admin/visitor-registration/visitorRegistration', ['registrations' => $registrations]);
        }
    }

    function searchVisitorRegistration(Request $request) {
        $registrations = VisitorRegistration::join('students', 'students.student_id', '=', 'visitor_registrations.student_id')
                                            ->join('users', 'users.id', '=', 'students.user_id')
                                            ->where('visitor_registrations.visitor_name', 'like', '%' . $request->search . '%')
                                            ->orWhere('users.name', 'like', '%' . $request->search . '%')
                                            ->orWhere('visitor_registrations.status', 'like', '%' . $request->search . '%')
                                            ->select('visitor_registrations.visitor_reg_id as visitor_reg_id',
                                                     'visitor_registrations.visitor_name as visitor_name',
                                                     'visitor_registrations.visit_date as visit_date',
                                                     'visitor_registrations.visit_time as visit_time',
                                                     'visitor_registrations.duration as duration',
                                                     'users.name as resident_name',
                                                     'visitor_registrations.status as status',)
                                            ->orderBy('visitor_registrations.visitor_reg_id', 'desc')
                                            ->paginate(10);

        return view('admin/visitor-registration/visitorRegistration', ['registrations' => $registrations]);
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
        } else {
            $registration = VisitorRegistration::join('students', 'students.student_id', '=', 'visitor_registrations.student_id')
                                               ->join('users', 'users.id', '=', 'students.user_id')
                                               ->leftjoin('visits', 'visits.visitor_reg_id', '=', 'visitor_registrations.visitor_reg_id')
                                               ->where('visitor_registrations.visitor_reg_id', '=', $id)
                                               ->select('visitor_registrations.visitor_reg_id as visitor_reg_id',
                                                        'visitor_registrations.created_at as applied_date',
                                                        'users.name as resident_name',
                                                        'students.resident_id as resident_id',
                                                        'visitor_registrations.visitor_name as visitor_name',
                                                        'visitor_registrations.visit_purpose as visit_purpose',
                                                        'visitor_registrations.visit_date as visit_date',
                                                        'visitor_registrations.visit_time as visit_time',
                                                        'visitor_registrations.duration as duration',
                                                        'visitor_registrations.status as status',
                                                        'visits.check_in_time as check_in_time',
                                                        'visits.check_out_time as check_out_time',
                                                        'visitor_registrations.note as note',)
                                               ->orderBy('visitor_registrations.visitor_reg_id', 'desc')
                                               ->first();

            return view('admin/visitor-registration/visitorRegistrationDetails', compact('registration'));
        }
    }

    public function cancelVisitorRegistration($id) {

        VisitorRegistration::find($id)
                          ->update(['status' => 'Canceled']);

        return redirect(route('resident-visitorRegistrationDetails', ['id' => $id]))->with("success", "Your visitor registration has been canceled successfully!");
    }

    public function approveVisitorRegistration($id) {
        
        $directoryPath = public_path('images/visitorQR');

        // Generate a QR code
        $qrCode = QrCode::format('svg')->size(200)->generate('admin-visitorRegistrationDetails-' . $id);

        // Store the QR code
        $directoryPath = public_path('images/visitorQR');
        $fileName = 'visitor_' . time() . '.svg';
        File::put($directoryPath . '/' . $fileName, $qrCode);

        // Save QR code in db
        VisitorRegistration::find($id)
                           ->update(['status' => 'Approved', 'qr_code' => $fileName]);

        return redirect(route('admin-visitorRegistrationDetails', ['id' => $id]))->with("success", "This visitor registration has been approved successfully!");
    }

    public function rejectVisitorRegistration($id, Request $request) {

        VisitorRegistration::find($id)
                          ->update(['status' => 'Rejected', 'note' => $request->note]);

        return redirect(route('admin-visitorRegistrationDetails', ['id' => $id]))->with("success", "This visitor registration has been rejected successfully!");
    }

    public function scanVisitorEntry($id) {

        $visitor = VisitorRegistration::find($id);

        if($visitor) {
            $visit = Visit::where('visitor_reg_id', '=', $id)->first();
            $currentDate = now();

            //check whether enter during the date registered
            if(now()->format('Y-m-d') == $visitor->visit_date) {

                if(!$visit) {
                    //record check in
                    Visit::create([
                        'visitor_reg_id' => $id,
                        'check_in_time' => now(),
                    ]);
    
                    return redirect(route('admin-visitorRegistrationDetails', ['id' => $id]))->with("success", "Visitor checked in successfully!");
                } else if ($visit->check_out_time == null){
                    //record check out
                    Visit::where('visitor_reg_id', '=', $id)
                    ->update([
                        'check_out_time' => now(),
                    ]);
    
                    return redirect(route('admin-visitorRegistrationDetails', ['id' => $id]))->with("success", "Visitor checked out successfully!");
                } else {
                    //invalid qr code
                    return redirect(route('admin-visitorRegistrationDetails', ['id' => $id]))->with("error", "This visitor qr code has been used.");
                }

            } else {
                return redirect(route('admin-visitorRegistrationDetails', ['id' => $id]))->with("error", "Wrong entry date.");
            }
            
        } else {
            return redirect(route('admin-visitorRegistration'))->with("error", "Invalid QR code.");
        }
    }
}
