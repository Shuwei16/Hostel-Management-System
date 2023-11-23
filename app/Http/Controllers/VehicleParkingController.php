<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingApplication;
use App\Models\Student;

class VehicleParkingController extends Controller
{
    function vehicleParkingPassList() {

        //display for resident
        if(auth()->user()->role == 1) {
            $applications = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                              ->where('students.user_id', '=', auth()->id())
                                              ->select('parking_applications.parking_application_id as parking_application_id',
                                                       'parking_applications.make as make',
                                                       'parking_applications.model as model',
                                                       'parking_applications.year as year',
                                                       'parking_applications.plate_no as plate_no',
                                                       'parking_applications.color as color',
                                                       'parking_applications.created_at as applied_date',
                                                       'parking_applications.status as status',)
                                              ->orderBy('parking_applications.parking_application_id', 'desc')
                                              ->paginate(10);

            return view('resident/vehicle-parking-pass/vehicleParkingPass', ['applications' => $applications]);
        
        //display for admin
        } else {
            $applications = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                              ->join('users', 'users.id', '=', 'students.user_id')
                                              ->select('parking_applications.parking_application_id as parking_application_id',
                                                       'parking_applications.make as make',
                                                       'parking_applications.model as model',
                                                       'parking_applications.year as year',
                                                       'parking_applications.plate_no as plate_no',
                                                       'parking_applications.color as color',
                                                       'users.name as resident_name',
                                                       'parking_applications.status as status',)
                                              ->orderBy('parking_applications.parking_application_id', 'desc')
                                              ->paginate(10);

            return view('admin/vehicle-parking-pass/vehicleParkingPassApps', ['applications' => $applications]);
        }
        
    }

    function searchVehicleParkingPassList(Request $request) {
        $applications = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                          ->join('users', 'users.id', '=', 'students.user_id')
                                          ->where('users.name', 'like', '%' . $request->search . '%')
                                          ->orWhere('parking_applications.status', 'like', '%' . $request->search . '%')
                                          ->select('parking_applications.parking_application_id as parking_application_id',
                                                   'parking_applications.make as make',
                                                   'parking_applications.model as model',
                                                   'parking_applications.year as year',
                                                   'parking_applications.plate_no as plate_no',
                                                   'parking_applications.color as color',
                                                   'users.name as resident_name',
                                                   'parking_applications.status as status',)
                                          ->orderBy('parking_applications.parking_application_id', 'desc')
                                          ->paginate(10);

        return view('admin/vehicle-parking-pass/vehicleParkingPassApps', ['applications' => $applications]);
    }

    function applyParkingPass() {

        $appliedPass = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                         ->where('students.user_id', '=', auth()->id())
                                         ->whereIn('status', ['Pending Approval', 'Approved'])
                                         ->first();

        return view('resident/vehicle-parking-pass/applyVehicleParkingPass', compact('appliedPass'));
    }

    function applyParkingPassPost(Request $request) {
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'color' => 'required',
            'plate_no' => 'required',
        ]);

        $student = Student::where('user_id', '=', auth()->id())
                             ->first();

        $application = ParkingApplication::create([
            'student_id' => $student->student_id,
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'color' => $request->color,
            'plate_no' => $request->plate_no,
            'status' => 'Pending Approval',
        ]);
        
        return redirect(route('resident-vehicleParkingPassDetails', ['id'=>$application->parking_application_id]))->with("success", "Your vehicle parking pass has been applied successfully! Please waiting for the approval.");
    }

    function parkingPassDetails($id) {

        if(auth()->user()->role == 1) {
            $application = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                             ->where('parking_applications.parking_application_id', '=', $id)
                                             ->select('parking_applications.parking_application_id as parking_application_id',
                                                      'parking_applications.make as make',
                                                      'parking_applications.model as model',
                                                      'parking_applications.year as year',
                                                      'parking_applications.plate_no as plate_no',
                                                      'parking_applications.color as color',
                                                      'parking_applications.created_at as applied_date',
                                                      'parking_applications.status as status',
                                                      'parking_applications.note as note',)
                                             ->first();
            
            return view('resident/vehicle-parking-pass/vehicleParkingPassDetails', compact('application'));
        } else {
            $application = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                             ->join('users', 'users.id', '=', 'students.user_id')
                                             ->where('parking_applications.parking_application_id', '=', $id)
                                             ->select('parking_applications.parking_application_id as parking_application_id',
                                                      'parking_applications.created_at as applied_date',
                                                      'users.name as resident_name',
                                                      'students.resident_id as resident_id',
                                                      'parking_applications.make as make',
                                                      'parking_applications.model as model',
                                                      'parking_applications.year as year',
                                                      'parking_applications.plate_no as plate_no',
                                                      'parking_applications.color as color',
                                                      'parking_applications.status as status',
                                                      'parking_applications.note as note',)
                                             ->first();

            return view('admin/vehicle-parking-pass/vehicleParkingPassDetails', compact('application'));
        }
    }

    function updateVehicleInfo($id) {
        $application = ParkingApplication::join('students', 'students.student_id', '=', 'parking_applications.student_id')
                                         ->where('parking_applications.parking_application_id', '=', $id)
                                         ->select('parking_applications.parking_application_id as parking_application_id',
                                                 'parking_applications.make as make',
                                                 'parking_applications.model as model',
                                                 'parking_applications.year as year',
                                                 'parking_applications.plate_no as plate_no',
                                                 'parking_applications.color as color')
                                         ->first();

        return view('resident/vehicle-parking-pass/updateVehicleInfo', compact('application'));
    }

    function updateVehicleInfoPost(Request $request) {
        $request->validate([
            'id' => 'required',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'color' => 'required',
            'plate_no' => 'required',
        ]);
        
        ParkingApplication::find($request->id)
        ->update([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'color' => $request->color,
            'plate_no' => $request->plate_no,
            'status' => 'Pending Approval',
        ]);

        return redirect(route('resident-vehicleParkingPassDetails', ['id'=>$request->id]))->with("success", "Your vehicle info has been updated successfully! Please waiting for the approval.");
    }

    public function cancelParkingPass($id) {

        ParkingApplication::find($id)
                          ->update(['status' => 'Canceled']);

        return redirect(route('resident-vehicleParkingPassDetails', ['id' => $id]))->with("success", "Your vehicle parking pass has been canceled successfully!");
    }

    public function approveParkingPass($id) {

        ParkingApplication::find($id)
                          ->update(['status' => 'Approved']);

        return redirect(route('admin-vehicleParkingPassDetails', ['id' => $id]))->with("success", "This vehicle parking pass application has been approved successfully!");
    }

    public function rejectParkingPass($id, Request $request) {

        ParkingApplication::find($id)
                          ->update(['status' => 'Rejected', 'note' => $request->note]);

        return redirect(route('admin-vehicleParkingPassDetails', ['id' => $id]))->with("success", "This vehicle parking pass application has been rejected successfully!");
    }
}
