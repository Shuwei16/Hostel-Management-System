<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Facades\File;

class FaceRecognitionController extends Controller
{
    function scanFace(){
        $directoryPath = public_path('labels');
        $files = glob($directoryPath . "/*");
        $subdirectories = [];

        foreach ($files as $file) {
            if (is_dir($file)) {
                $subdirectories[] = basename($file);
            }
        }

        return view('admin/resident-attendance/scanFace', compact('subdirectories'));
    }

    function scanFacePost(Request $request){
        $resident = explode('_', $request->recognizedLabel);
        
        $residentInfo = Student::where('resident_id', '=', $resident[0])
                               ->first();

        $atdRecord = Attendance::where('student_id', '=', $residentInfo->student_id)
                               ->orderBy('attendance_id', 'desc')
                               ->first();

        if($atdRecord && $atdRecord->attendance_type == 'check in') {
            $type = 'check out';
        } else {
            $type = 'check in';
        }

        Attendance::create([
            'student_id' => $residentInfo->student_id,
            'attendance_type' => $type
        ]);

        return redirect(route('admin-attendance'))->with("success", "Attendance recorded: " . $request->recognizedLabel . " Type: " . $type);
    }

    public function storePhoto(Request $request){
        // Specify the directory path
        $student = Student::where('user_id', '=', auth()->id())
                          ->join('users', 'students.user_id', '=', 'users.id')
                          ->select(
                            'students.resident_id as resident_id',
                            'users.name as name'
                          )
                          ->first();

        $directoryPath = public_path('labels/' . $student->resident_id . '_' . $student->name);
        // Create the directory
        File::makeDirectory($directoryPath);

        // Extract the base64 data from the data URL
        $photo1base64Data = explode(',', $request->photo1)[1];
        $photo2base64Data = explode(',', $request->photo2)[1];
        $photo3base64Data = explode(',', $request->photo3)[1];
        $photo4base64Data = explode(',', $request->photo4)[1];

        // Decode the base64 data into binary
        $photo1binaryData = base64_decode($photo1base64Data);
        $photo2binaryData = base64_decode($photo2base64Data);
        $photo3binaryData = base64_decode($photo3base64Data);
        $photo4binaryData = base64_decode($photo4base64Data);

        // Save the binary data as an image file
        file_put_contents($directoryPath . '/1.png', $photo1binaryData);
        file_put_contents($directoryPath . '/2.png', $photo2binaryData);
        file_put_contents($directoryPath . '/3.png', $photo3binaryData);
        file_put_contents($directoryPath . '/4.png', $photo4binaryData);

        return redirect(route('resident-profile'))->with('success', 'Your photo has been recorded successfully!');
    }

    public function showAllAttendances() {
        $attendances = Attendance::join('students', 'students.student_id', '=', 'attendances.student_id')
                                 ->join('users', 'users.id', '=', 'students.user_id')
                                 ->select(
                                    'users.name as resident_name',
                                    'students.resident_id as resident_id',
                                    'attendances.attendance_type as attendance_type',
                                    'attendances.created_at as datetime'
                                    )
                                 ->orderby('attendance_id', 'desc')
                                 ->paginate(10);

        return view('admin/resident-attendance/attendance', compact('attendances'));
    }

    public function showResidentAttendances() {
        $attendances = Attendance::join('students', 'students.student_id', '=', 'attendances.student_id')
                                 ->join('users', 'users.id', '=', 'students.user_id')
                                 ->where('users.id', '=', auth()->id())
                                 ->select(
                                    'users.name as resident_name',
                                    'students.resident_id as resident_id',
                                    'attendances.attendance_type as attendance_type',
                                    'attendances.created_at as datetime'
                                    )
                                 ->orderby('attendance_id', 'desc')
                                 ->paginate(10);

        return view('resident/attendance/attendance', compact('attendances'));
    }
}
