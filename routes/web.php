<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FloorPlanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
//use App\Http\Controllers\PythonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Homepage */
Route::get('/', function () {
    return view('home');
})->name('home');

/* Authentication */
//login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
//Sign up
Route::get('signup', [AuthController::class, 'signup'])->name('signup');
Route::post('signup', [AuthController::class, 'signupPost'])->name('signup.post');
//link to forgot password page
Route::get('forgotpassword', function () {
    return view('auth/forgotpassword');
});
//logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


/* Non-Resident */
//registration
Route::get('non-resident-new', [RegistrationController::class, 'newRegistration'])->name('non-resident-new')->middleware('nonresident');
Route::post('non-resident-new', [RegistrationController::class, 'submitNewRegistration'])->name('non-resident-new.post');
Route::get('non-resident-history', [RegistrationController::class, 'history'])->name('non-resident-history');
Route::get('non-resident-approval-{id}', [RegistrationController::class, 'showApprovalDetails'])->name('non-resident-approval');
Route::put('non-resident-approval-{id}', [RegistrationController::class, 'cancelRegistration'])->name('non-resident-approval.cancel');

//payment
Route::get('non-resident-payment-{id}', [PaymentController::class, 'payment'])->name('non-resident-payment');
Route::post('non-resident-payment-method', [PaymentController::class, 'paymentMethod'])->name('non-resident-payment-method');
Route::post('non-resident-confirm-payment', [PaymentController::class, 'completePayment'])->name('non-resident-confirm-payment');
Route::get('payment-receipt-{id}', [PaymentController::class, 'generateReceipt'])->name('payment-receipt');


/* Resident */
//Profile
Route::get('resident-profile', [ProfileController::class, 'showProfile'])->name('resident-profile');
Route::get('resident-editProfile', [ProfileController::class, 'editProfile'])->name('resident-editProfile');
Route::post('resident-editProfile', [ProfileController::class, 'editProfilePost'])->name('resident-editProfile.post');

//Announcements
Route::get('resident-announcement', function () {
    return view('resident/announcement/announcement');
})->name('resident-announcement')->middleware('resident');
Route::get('resident-announcementDetails', function () {
    return view('resident/announcement/announcementDetails');
})->name('resident-announcementDetails');

//Registration
Route::get('resident-registrationHistory', [RegistrationController::class, 'history'])->name('resident-registrationHistory');
Route::get('resident-registrationDetails-{id}', [RegistrationController::class, 'showApprovalDetails'])->name('resident-registrationDetails');
Route::put('resident-registrationDetails-{id}', [RegistrationController::class, 'cancelRegistration'])->name('resident-registrationDetails.cancel');
Route::get('resident-extensionRegistration', [RegistrationController::class, 'extensionRegistration'])->name('resident-extensionRegistration');
Route::post('resident-extensionRegistration', [RegistrationController::class, 'submitExtensionRegistration'])->name('resident-extensionRegistration.post');

//Payment
Route::get('resident-payment-{id}', [PaymentController::class, 'payment'])->name('resident-payment');
Route::post('resident-payment-method', [PaymentController::class, 'paymentMethod'])->name('resident-payment-method');
Route::post('resident-confirm-payment', [PaymentController::class, 'completePayment'])->name('resident-confirm-payment');

//Room Maintenance Booking
Route::get('resident-maintenance', function () {
    return view('resident/room-maintenance/maintenance');
});
Route::get('resident-addMaintenance', function () {
    return view('resident/room-maintenance/addMaintenance');
});
Route::get('resident-maintenanceDetails', function () {
    return view('resident/room-maintenance/maintenanceDetails');
});

//Vehicle Parking Applications
Route::get('resident-vehicleParkingPass', function () {
    return view('resident/vehicle-parking-pass/vehicleParkingPass');
});
Route::get('resident-applyVehicleParkingPass', function () {
    return view('resident/vehicle-parking-pass/applyVehicleParkingPass');
});
Route::get('resident-vehicleParkingPassDetails', function () {
    return view('resident/vehicle-parking-pass/vehicleParkingPassDetails');
});
Route::get('resident-updateVehicleInfo', function () {
    return view('resident/vehicle-parking-pass/updateVehicleInfo');
});

//Visitor Entry Registration
Route::get('resident-visitorRegistration', function () {
    return view('resident/visitor-registration/visitorRegistration');
});
Route::get('resident-addVisitorRegistration', function () {
    return view('resident/visitor-registration/addVisitorRegistration');
});
Route::get('resident-visitorRegistrationDetails', function () {
    return view('resident/visitor-registration/visitorRegistrationDetails');
});


//attendance
Route::get('resident-attendance', function () {
    return view('resident/attendance/attendance');
});


/* Admin */

//dashboard
Route::get('admin-dashboard', function () {
    return view('admin/dashboard/dashboard');
})->name('admin-dashboard')->middleware('admin');

//announcements
Route::get('admin-announcement', [AnnouncementController::class, 'announcementList'])->name('admin-announcement');
Route::get('admin-announcementDetails-{id}', [AnnouncementController::class, 'announcementDetails'])->name('admin-announcementDetails');
Route::post('admin-comment', [AnnouncementController::class, 'postComment'])->name('admin-comment');
Route::get('admin-addAnnouncement', [AnnouncementController::class, 'addAnnouncement'])->name('admin-addAnnouncement');
Route::post('admin-addAnnouncement', [AnnouncementController::class, 'addAnnouncementPost'])->name('admin-addAnnouncement.post');
Route::get('admin-editAnnouncement-{id}', [AnnouncementController::class, 'editAnnouncement'])->name('admin-editAnnouncement');
Route::post('admin-editAnnouncement-{id}', [AnnouncementController::class, 'editAnnouncementPost'])->name('admin-editAnnouncement.post');
Route::delete('admin-deleteAnnouncement-{id}', [AnnouncementController::class, 'deleteAnnouncement'])->name('admin-deleteAnnouncement');

//registrations
Route::get('admin-registrationRecord', [RegistrationController::class, 'showAllRegistrations'])->name('admin-registrationRecord');
Route::get('admin-registrationDetails-{id}', [RegistrationController::class, 'showRegistrationDetails'])->name('admin-registrationDetails');

//semesters
Route::get('admin-semesters', [RegistrationController::class, 'showAllSemesters'])->name('admin-semesters');
Route::get('admin-addSemester', [RegistrationController::class, 'addSemester'])->name('admin-addSemester');
Route::post('admin-addSemester', [RegistrationController::class, 'addSemesterPost'])->name('admin-addSemester.post');
Route::get('admin-viewSemester-{id}', [RegistrationController::class, 'showSemesterDetails'])->name('admin-viewSemester');
Route::delete('admin-semesters-{id}', [RegistrationController::class, 'deleteSemester'])->name('admin-semesters.delete');
Route::get('admin-editSemester-{id}', [RegistrationController::class, 'editSemester'])->name('admin-editSemester');
Route::post('admin-editSemester-{id}', [RegistrationController::class, 'editSemesterPost'])->name('admin-editSemester.post');

//rooms
Route::get('admin-roomManagement', [FloorPlanController::class, 'showFloorPlan'])->name('admin-roomManagement');
Route::post('admin-roomManagement', [FloorPlanController::class, 'filter'])->name('admin-roomManagement.post');
Route::get('admin-roomDetails-{id}', [FloorPlanController::class, 'showRoomDetails'])->name('admin-roomDetails');
Route::put('admin-roomCheckIn-{room_id}-{user_id}-{registration_id}', [FloorPlanController::class, 'roomCheckIn'])->name('admin-roomCheckIn');
Route::put('admin-roomCheckOut-{room_id}-{user_id}-{registration_id}', [FloorPlanController::class, 'roomCheckOut'])->name('admin-roomCheckOut');

//room maintenances
Route::get('admin-todaysMaintenance', function () {
    return view('admin/room-maintenance/todaysMaintenance');
});
Route::get('admin-allMaintenances', function () {
    return view('admin/room-maintenance/allMaintenances');
});
Route::get('admin-maintenanceDetails', function () {
    return view('admin/room-maintenance/maintenanceDetails');
});

//vehicle parking applications
Route::get('admin-vehicleParkingPassApps', function () {
    return view('admin/vehicle-parking-pass/vehicleParkingPassApps');
});
Route::get('admin-vehicleParkingPassDetails', function () {
    return view('admin/vehicle-parking-pass/vehicleParkingPassDetails');
});

//visitor entry registrations
Route::get('admin-visitorRegistration', function () {
    return view('admin/visitor-registration/visitorRegistration');
});
Route::get('admin-visitorRegistrationDetails', function () {
    return view('admin/visitor-registration/visitorRegistrationDetails');
});

//resident attendances
Route::get('admin-attendance', function () {
    return view('admin/resident-attendance/attendance');
});


//Route::get('run-python', [PythonController::class, 'execute'])->name('run-python');