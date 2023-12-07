<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Registration;
use App\Models\Room;

class DashboardController extends Controller
{
    function showDashboard() {
        $semester = Semester::where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->first();

        $totalRegistrations = Registration::where('semester_id', '=', $semester->semester_id)->count();

        $newRegistrations = Registration::where('semester_id', '=', $semester->semester_id)
                                        ->where('registration_type', '=', 'New Resident')
                                        ->count();
        
        $roomOccupancy = Room::join('blocks', 'blocks.block_id', '=', 'rooms.block_id')
                             ->select('gender', \DB::raw('SUM(occupied_slots) as total_occupied_slots'))
                             ->groupBy('gender')
                             ->get();
        
        $semOccupancy = Registration::join('semesters', 'semesters.semester_id', '=', 'registrations.semester_id')
                                    ->select('semester_name', \DB::raw('COUNT(registrations.registration_id) as total_number'))
                                    ->groupBy('semester_name')
                                    ->orderBy('semesters.semester_id')
                                    ->get();

        return view('admin/dashboard/dashboard', compact('semester', 'totalRegistrations', 'newRegistrations', 'roomOccupancy', 'semOccupancy'));
    }

    function printReport() {
        $semester = Semester::where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->first();

        $totalRegistrations = Registration::where('semester_id', '=', $semester->semester_id)->count();

        $newRegistrations = Registration::where('semester_id', '=', $semester->semester_id)
                                        ->where('registration_type', '=', 'New Resident')
                                        ->count();
        
        $roomOccupancy = Room::join('blocks', 'blocks.block_id', '=', 'rooms.block_id')
                             ->select('gender', \DB::raw('SUM(occupied_slots) as total_occupied_slots'))
                             ->groupBy('gender')
                             ->get();
        
        $semOccupancy = Registration::join('semesters', 'semesters.semester_id', '=', 'registrations.semester_id')
                                    ->select('semester_name', \DB::raw('COUNT(registrations.registration_id) as total_number'))
                                    ->groupBy('semester_name')
                                    ->orderBy('semesters.semester_id')
                                    ->get();

        return view('admin/dashboard/printReport', compact('semester', 'totalRegistrations', 'newRegistrations', 'roomOccupancy', 'semOccupancy'));
    }
}
