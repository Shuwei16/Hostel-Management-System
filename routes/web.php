<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FloorPlanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\VehicleParkingController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;

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
Route::get('/', [AnnouncementController::class, 'home'])->name('home');
Route::get('newsDetails-{id}', [AnnouncementController::class, 'newsDetails'])->name('newsDetails');

/* Authentication */
//login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
//Sign up
Route::get('signup', [AuthController::class, 'signup'])->name('signup');
Route::post('signup', [AuthController::class, 'signupPost'])->name('signup.post');
//link to forgot password page
Route::get('forgotpassword', [AuthController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('forgotpassword', [AuthController::class, 'forgotPasswordPost'])->name('forgotpassword.post');
Route::get('resetpassword-{id}', [AuthController::class, 'resetPassword'])->name('resetpassword');
Route::post('resetpassword-{id}', [AuthController::class, 'resetPasswordPost'])->name('resetpassword.post');
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
Route::get('resident-recordFace', function () { return view('resident/profile/recordFace'); })->name('resident-recordFace');
Route::post('resident-recordFace', [FaceRecognitionController::class, 'storePhoto'])->name('resident-recordFace.post');
Route::get('resident-changePassword', function () { return view('resident/profile/changePassword'); })->name('resident-changePassword');
Route::post('resident-changePassword', [AuthController::class, 'changePasswordPost'])->name('resident-changePassword.post');
Route::get('resident-forgotPassword', function () { return view('resident/profile/forgotPassword'); })->name('resident-forgotPassword');
Route::post('resident-forgotPassword', [AuthController::class, 'residentForgotPasswordPost'])->name('resident-forgotPassword.post');

//Announcements
Route::get('resident-announcement', [AnnouncementController::class, 'residentAnnouncement'])->name('resident-announcement');
Route::get('resident-announcementDetails-{id}', [AnnouncementController::class, 'announcementDetails'])->name('resident-announcementDetails');
Route::post('resident-comment', [AnnouncementController::class, 'postComment'])->name('resident-comment');

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
Route::get('resident-maintenance', [MaintenanceController::class, 'residentMaintenanceList'])->name('resident-maintenance');
Route::get('resident-addMaintenance', [MaintenanceController::class, 'addMaintenance'])->name('resident-addMaintenance');
Route::post('resident-addMaintenance.action', [MaintenanceController::class, 'addMaintenancePost'])->name('resident-addMaintenance.action');
Route::get('resident-addMaintenance.action', [MaintenanceController::class, 'addMaintenanceGet'])->name('resident-addMaintenance.action');
Route::get('resident-maintenanceDetails-{id}', [MaintenanceController::class, 'residentMaintenanceDetails'])->name('resident-maintenanceDetails');
Route::put('resident-maintenanceDetails-{id}', [MaintenanceController::class, 'cancelMaintenance'])->name('resident-maintenanceDetails.cancel');

//Vehicle Parking Applications
Route::get('resident-vehicleParkingPass', [VehicleParkingController::class, 'vehicleParkingPassList'])->name('resident-vehicleParkingPass');
Route::get('resident-applyVehicleParkingPass', [VehicleParkingController::class, 'applyParkingPass'])->name('resident-applyVehicleParkingPass');
Route::post('resident-applyVehicleParkingPass', [VehicleParkingController::class, 'applyParkingPassPost'])->name('resident-applyVehicleParkingPass.post');
Route::get('resident-vehicleParkingPassDetails-{id}', [VehicleParkingController::class, 'parkingPassDetails'])->name('resident-vehicleParkingPassDetails');
Route::get('resident-updateVehicleInfo-{id}', [VehicleParkingController::class, 'updateVehicleInfo'])->name('resident-updateVehicleInfo');
Route::post('resident-updateVehicleInfo-{id}', [VehicleParkingController::class, 'updateVehicleInfoPost'])->name('resident-updateVehicleInfo.post');
Route::put('resident-vehicleParkingPassDetails-{id}', [VehicleParkingController::class, 'cancelParkingPass'])->name('resident-vehicleParkingPass.cancel');

//Visitor Entry Registration
Route::get('resident-visitorRegistration', [VisitorController::class, 'visitorRegistrationList'])->name('resident-visitorRegistration');
Route::get('resident-addVisitorRegistration', [VisitorController::class, 'addVisitorRegistration'])->name('resident-addVisitorRegistration');
Route::post('resident-addVisitorRegistration', [VisitorController::class, 'addVisitorRegistrationPost'])->name('resident-addVisitorRegistration.post');
Route::get('resident-visitorRegistrationDetails-{id}', [VisitorController::class, 'visitorRegistrationDetails'])->name('resident-visitorRegistrationDetails');
Route::put('resident-visitorRegistrationDetails-{id}', [VisitorController::class, 'cancelVisitorRegistration'])->name('resident-visitorRegistration.cancel');

//attendance
Route::get('resident-attendance', [FaceRecognitionController::class, 'showResidentAttendances'])->name('resident-attendance');

//chat
Route::get('resident-chat', [ChatController::class, 'residentChat'])->name('resident-chat');
Route::post('resident-chat', [ChatController::class, 'residentSendMessage'])->name('resident-chat.post');

/* Admin */
//dashboard
Route::get('admin-dashboard', [DashboardController::class, 'showDashboard'])->name('admin-dashboard')->middleware('admin');
Route::get('admin-printReport', [DashboardController::class, 'printReport'])->name('admin-printReport');

//announcements
Route::get('admin-announcement', [AnnouncementController::class, 'announcementList'])->name('admin-announcement');
Route::get('admin-announcement-search', [AnnouncementController::class, 'searchAnnouncement'])->name('admin-announcement.search');
Route::get('admin-announcementDetails-{id}', [AnnouncementController::class, 'announcementDetails'])->name('admin-announcementDetails');
Route::post('admin-comment', [AnnouncementController::class, 'postComment'])->name('admin-comment');
Route::get('admin-addAnnouncement', [AnnouncementController::class, 'addAnnouncement'])->name('admin-addAnnouncement');
Route::post('admin-addAnnouncement', [AnnouncementController::class, 'addAnnouncementPost'])->name('admin-addAnnouncement.post');
Route::get('admin-editAnnouncement-{id}', [AnnouncementController::class, 'editAnnouncement'])->name('admin-editAnnouncement');
Route::post('admin-editAnnouncement-{id}', [AnnouncementController::class, 'editAnnouncementPost'])->name('admin-editAnnouncement.post');
Route::delete('admin-deleteAnnouncement-{id}', [AnnouncementController::class, 'deleteAnnouncement'])->name('admin-deleteAnnouncement');

//registrations
Route::get('admin-registrationRecord', [RegistrationController::class, 'showAllRegistrations'])->name('admin-registrationRecord');
Route::get('admin-registrationRecord-search', [RegistrationController::class, 'searchRegistrations'])->name('admin-registrationRecord.search');
Route::get('admin-registrationDetails-{id}', [RegistrationController::class, 'showRegistrationDetails'])->name('admin-registrationDetails');

//semesters
Route::get('admin-semesters', [RegistrationController::class, 'showAllSemesters'])->name('admin-semesters');
Route::get('admin-semesters-search', [RegistrationController::class, 'searchSemesters'])->name('admin-semesters.search');
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
Route::get('admin-todaysMaintenance', [MaintenanceController::class, 'todaysMaintenances'])->name('admin-todaysMaintenance');
Route::get('admin-allMaintenances', [MaintenanceController::class, 'allMaintenances'])->name('admin-allMaintenances');
Route::get('admin-allMaintenances-search', [MaintenanceController::class, 'searchAllMaintenances'])->name('admin-allMaintenances.search');
Route::get('admin-maintenanceDetails-{id}', [MaintenanceController::class, 'adminMaintenanceDetails'])->name('admin-maintenanceDetails');
Route::put('admin-maintenanceDetails-{id}', [MaintenanceController::class, 'doneMaintenance'])->name('admin-maintenanceDetails.done');

//vehicle parking applications
Route::get('admin-vehicleParkingPassApps', [VehicleParkingController::class, 'vehicleParkingPassList'])->name('admin-vehicleParkingPassApps');
Route::get('admin-vehicleParkingPassApps-search', [VehicleParkingController::class, 'searchVehicleParkingPass'])->name('admin-vehicleParkingPassApps.search');
Route::get('admin-vehicleParkingPassDetails-{id}', [VehicleParkingController::class, 'parkingPassDetails'])->name('admin-vehicleParkingPassDetails');
Route::post('admin-vehicleParkingPassDetails-{id}/approve', [VehicleParkingController::class, 'approveParkingPass'])->name('admin-vehicleParkingPass.approve');
Route::post('admin-vehicleParkingPassDetails-{id}/reject', [VehicleParkingController::class, 'rejectParkingPass'])->name('admin-vehicleParkingPass.reject');

//visitor entry registrations
Route::get('admin-visitorRegistration', [VisitorController::class, 'visitorRegistrationList'])->name('admin-visitorRegistration');
Route::get('admin-visitorRegistration-search', [VisitorController::class, 'searchVisitorRegistration'])->name('admin-visitorRegistration.search');
Route::get('admin-visitorRegistrationDetails-{id}', [VisitorController::class, 'visitorRegistrationDetails'])->name('admin-visitorRegistrationDetails');
Route::get('admin-scanQR', function () {return view('admin/visitor-registration/scanQR');});
Route::post('admin-visitorRegistrationDetails-{id}/approve', [VisitorController::class, 'approveVisitorRegistration'])->name('admin-visitorRegistration.approve');
Route::post('admin-visitorRegistrationDetails-{id}/reject', [VisitorController::class, 'rejectVisitorRegistration'])->name('admin-visitorRegistration.reject');
Route::get('admin-visitorRegistrationDetails-{id}/scan', [VisitorController::class, 'scanVisitorEntry'])->name('admin-visitorRegistration.scan');

//resident attendances
Route::get('admin-attendance', [FaceRecognitionController::class, 'showAllAttendances'])->name('admin-attendance');
Route::get('admin-attendance-search', [FaceRecognitionController::class, 'searchAttendances'])->name('admin-attendance.search');
Route::get('admin-scanFace', [FaceRecognitionController::class, 'scanFace'])->name('admin-scanFace');
Route::post('admin-scanFace', [FaceRecognitionController::class, 'scanFacePost'])->name('admin-scanFace.post');

//security
Route::get('admin-security', function () {return view('admin/security/security');});

//messages
Route::get('admin-message', [ChatController::class, 'adminMessages'])->name('admin-message');
Route::get('admin-message-search', [ChatController::class, 'searchChat'])->name('admin-message.search');
Route::post('admin-message', [ChatController::class, 'selectUser'])->name('admin-message.select');
Route::post('admin-message-sent', [ChatController::class, 'adminSendMessage'])->name('admin-message.post');