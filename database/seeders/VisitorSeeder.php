<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitorRegistration;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //dummy data for the first approved visitor
        VisitorRegistration::create([
            'student_id' => 1,
            'visitor_name' => 'Lee Ah Meng',
            'visit_purpose' => 'Drop luggages',
            'visit_date' => '2023-11-23',
            'visit_time' => "9:00:00",
            'duration' => "10",
            'status' => 'Pending Approval',
        ]);

        // Generate a QR code
        $qrCode = QrCode::format('svg')->size(200)->generate('admin-visitorRegistrationDetails-1');

        // Store the QR code
        $directoryPath = public_path('images/visitorQR');
        $fileName = 'visitor_' . time() . '.svg';
        File::put($directoryPath . '/' . $fileName, $qrCode);

        // Save QR code in db
        VisitorRegistration::find(1)
                           ->update(['status' => 'Approved', 'qr_code' => $fileName]);


        //dummy data for visitor registration record
        for($i=2; $i <= 15; $i++) {

            VisitorRegistration::create([
                'student_id' => rand(1, 5),
                'visitor_name' => 'Lee Ah Meng',
                'visit_purpose' => 'Drop luggages',
                'visit_date' => '2023-11-23',
                'visit_time' => "9:00:00",
                'duration' => "10",
                'status' => 'Pending Approval',
            ]);
        }
    }
}
