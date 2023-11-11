<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return redirect(route('admin-attendance'))->with("success", "Attendance recorded:".$request->recognizedLabel);
    }
}
