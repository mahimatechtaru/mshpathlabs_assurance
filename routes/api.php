<?php

use App\Http\Controllers\DoctorApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

// Onesignal Notification Test, Only for Developers.
// Route::get('/send-test-notification', [DoctorApiController::class, 'sendTestNotification']);

Route::post('/login', [UserApiController::class, 'apiLogin']);
Route::post('/register', [UserApiController::class, 'apiRegister']);
Route::post('/check_otp', [UserApiController::class, 'apiCheckOtp']);
Route::get('/resendOtp/{user_id}', [UserApiController::class, 'apiResendOtp']);
Route::post('/doctors', [UserApiController::class, 'apiDoctors']);
Route::get('/treatments', [UserApiController::class, 'apiTreatments']);
Route::get('/offers', [UserApiController::class, 'apiOffers']);
Route::post('near_by_doctor', [UserApiController::class, 'apiNearByDoctor']);
Route::post('doctor_details/{id}', [UserApiController::class, 'apiSingleDoctor']);
Route::post('/timeslot', [UserApiController::class, 'apiTimeslot']);
Route::get('/setting', [UserApiController::class, 'apiSetting']);
Route::get('/blogs', [UserApiController::class, 'apiBlogs']);
Route::get('/blog_details/{id}', [UserApiController::class, 'apiSingleBlog']);
Route::get('/pharamacies', [UserApiController::class, 'apipharmacy']);
Route::get('/pharmacy_details/{id}', [UserApiController::class, 'apiSinglepharmacy']);
Route::get('/medicine_details/{id}', [UserApiController::class, 'apiSingleMedicine']);
Route::post('/forgot_password', [UserApiController::class, 'apiForgotPassword']);
Route::post('treatment_wise_doctor/{treatment_id}', [UserApiController::class, 'apiTreatmentDoctor']);
Route::get('/banner', [UserApiController::class, 'apiBanner']);

Route::middleware('auth:api')->group(function () {
    Route::post('/book_appointment', [UserApiController::class, 'apiBooking']);
    Route::get('appointments', [UserApiController::class, 'apiAppointments']);
    Route::get('prescription/{appointment_id}', [UserApiController::class, 'apiAppointmentPrescription']);

    Route::post('update_profile', [UserApiController::class, 'apiUpdateProfile']);
    Route::post('update_image', [UserApiController::class, 'apiUpdateImage']);
    Route::post('book_medicine', [UserApiController::class, 'apiBookMedicine']);
    Route::get('medicines', [UserApiController::class, 'apiMedicines']);
    Route::get('single_medicine/{purchase_medicide_id}', [UserApiController::class, 'apiSingleMedicineDetails']);
    Route::post('cancel_appointment', [UserApiController::class, 'apiCancelAppointment']);
    Route::get('address', [UserApiController::class, 'apiShowAddress']);
    Route::post('add_address', [UserApiController::class, 'apiAddAddress']);
    Route::get('delete_address/{id}', [UserApiController::class, 'apiDeleteAddress']);
    Route::post('add_review', [UserApiController::class, 'apiAddReview']);
    Route::post('check_offer', [UserApiController::class, 'apiCheckCoupon']);
    Route::get('user_notification', [UserApiController::class, 'apiUserNotification']);
    Route::get('add_bookmark/{doctor_id}', [UserApiController::class, 'apiAddBookmark']);
    Route::get('faviroute_doctor', [UserApiController::class, 'apiFaviroute']);
    Route::post('/generateAgoraToken', [UserApiController::class, 'apiGenerateToken']);
    Route::get('/video_call_history', [UserApiController::class, 'apiVideoCallHistory']);
    Route::post('/add_call_history', [UserApiController::class, 'apiAddHistory']);
    Route::get('/send_notification', [UserApiController::class, 'apiSendNotification']);
    Route::get('/delete-account', [UserApiController::class, 'deleteAccount']);
    Route::get('/insurers', [UserApiController::class, 'insurers']);
    Route::get('/logout', [UserApiController::class, 'apiLogout']);
    Route::post('/send_message_to_doctor_notification', [UserApiController::class, 'apiSendMessageToDoctorNotificationTrigger']);
});
// Route::get('/send_notification',[UserApiController::class,'apiSendNotification']);

// ************* DOCTOR *******************//
Route::post('doctor_login', [DoctorApiController::class, 'apiDoctorLogin']);
Route::post('doctor_register', [DoctorApiController::class, 'apiDoctorRegister']);
Route::get('allMedicines', [DoctorApiController::class, 'apiMedicines']);

Route::middleware('auth:api')->group(function () {
    Route::get('doctor_appointment', [DoctorApiController::class, 'apiDoctorAppointment']);
    Route::get('appointment_details/{id}', [DoctorApiController::class, 'apiSingleAppointment']);
    Route::post('add_prescription', [DoctorApiController::class, 'apiAddPrescription']);
    Route::get('working_hours', [DoctorApiController::class, 'apiWorkingHours']);
    Route::post('update_time', [DoctorApiController::class, 'apiUpdateWorkingHours']);
    Route::get('doctor_profile', [DoctorApiController::class, 'apiLoginDoctor']);
    Route::post('update_doctor', [DoctorApiController::class, 'apiUpdateDoctor']);
    Route::get('doctor_review', [DoctorApiController::class, 'apiDoctorReview']);
    Route::get('treatment', [DoctorApiController::class, 'apiTreatment']);
    Route::get('categories/{treatment_id}', [DoctorApiController::class, 'apiCategory']);
    Route::get('expertise/{caegory_id}', [DoctorApiController::class, 'apiExpertise']);
    Route::get('hospitals', [DoctorApiController::class, 'apiHospital']);
    Route::post('status_change', [DoctorApiController::class, 'apiStatusChange']);
    Route::post('updatePatientVcall', [DoctorApiController::class, 'apiUpdatePatientVCallSwitch']);
    Route::get('appointment_history', [DoctorApiController::class, 'apiAppointmentHistory']);
    Route::get('payment', [DoctorApiController::class, 'apiPayment']);
    Route::post('payment', [DoctorApiController::class, 'apiPayment']);
    Route::get('subscription', [DoctorApiController::class, 'apiSubscription']);
    Route::get('finance_details', [DoctorApiController::class, 'apiFinanceDetails']);
    Route::get('notification', [DoctorApiController::class, 'apiNotification']);
    Route::post('purchase_subscrption', [DoctorApiController::class, 'apiPurchaseSubscription']);
    Route::post('doctor_update_image', [DoctorApiController::class, 'apiUpdateImage']);
    Route::get('cancel_appointment', [DoctorApiController::class, 'apiCancelAppointment']);
    Route::post('doctor_change_password', [DoctorApiController::class, 'apiDoctorChangePassword']);
    Route::post('/generateDoctorAgoraToken',[DoctorApiController::class, 'apiDoctorGenerateToken']);
    Route::post('/send_message_to_patient_notification', [DoctorApiController::class, 'apiSendMessageToPatientNotificationTrigger']);
    Route::get('/logout', [DoctorApiController::class, 'apiLogout']);
});
