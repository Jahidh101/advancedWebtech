<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\DelivarymanController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login/user',[CommonController::class,'loginSubmit']);
Route::get('/login/history',[AdminController::class,'allLoginHistory']);
Route::post('/forgot/password',[CommonController::class,'forgotPasswordSubmit']);
Route::post('/reset/password', [CommonController::class,'resetPasswordSubmit']);
Route::post('/register',[RegisterController::class, 'register']);

//redirect after login
Route::get('/admin/homepage',[AdminController::class,'adminHomepage'])->middleware('adminAuth');

//userType
Route::get('/getUserType/list',[AdminController::class,'userTypeList']);
Route::get('/getUserType/{id}',[AdminController::class,'getUserType']);
Route::post('/userType/edit',[AdminController::class,'userTypeEditSubmit']);
Route::post('/addUserType',[AdminController::class,'addUserTypeSubmit']);

//all_user & edit
Route::post('/addUser',[RegisterController::class, 'register']);
Route::get('/user/info/{username}',[CommonController::class,'userInfo']);
Route::post('/UserProfile/edit',[CommonController::class,'userProfileEditSubmit']);
Route::post('/add/profilePicture',[CommonController::class,'addProfilePictureSubmit']);
Route::get('/doctor/list',[AdminController::class,'doctorList']);
Route::get('/patient/list',[AdminController::class,'patientList']);

//delivaryman
Route::post('/add/delivaryman',[AdminController::class,'addDelivarymanSubmit']);
Route::get('/delivaryman/list',[AdminController::class,'delivarymanList']);
Route::post('/delivaryman/info',[AdminController::class,'delivarymanInfo']);
Route::get('/seller/delivaryman/list',[SellerController::class,'delivarymanList']);

//chat
Route::post('/doctor/list/chat',[PatientController::class,'doctorList']);
Route::post('/patient/list/chat',[DoctorController::class,'patientList']);

//medicine & diseases
Route::get('/medicineType/list',[SellerController::class,'medicineTypeList']);
Route::get('/medicineType/{id}',[SellerController::class,'medicineType']);
Route::post('/medicineType/add',[SellerController::class,'addMedicineTypeSubmit']);
Route::post('/medicineType/edit',[SellerController::class,'medicineTypeEditSubmit']);
Route::post('/medicine/add',[SellerController::class,'addMedicineSubmit']);
Route::get('/admin/medicine/list',[AdminController::class,'medicineList']);
Route::get('/medicine/list',[SellerController::class,'medicineList']);
Route::post('/medicine/info',[AdminController::class,'medicineGet']);
Route::post('/medicine/edit',[AdminController::class,'medicineEditSubmit']);
Route::post('/medicine/price/set',[AdminController::class,'medicinePriceSetSubmit']);
Route::get('/medicine/blocked/list',[AdminController::class,'medicineBlockedList']);
Route::post('/medicine/block',[AdminController::class,'medicineBlock']);
Route::post('/medicine/unblock',[AdminController::class,'medicineUnblock']);
Route::post('/medicine/add/cart',[PatientController::class,'medicineAddToCart']);
Route::post('/medicine/mycart',[PatientController::class,'myCart']);
Route::post('/medicine/mycart/delete',[PatientController::class,'myCartDelete']);
Route::post('/medicine/mycart/confirm/order',[PatientController::class,'myCartConfirmOrder']);
Route::post('/myorder/list',[PatientController::class,'myOrderList']);
Route::get('/pending/order/list',[SellerController::class,'pendingOrderList']);
Route::post('/pending/order/accept',[SellerController::class,'pendingOrderAccept']);
Route::post('/pending/order/reject',[SellerController::class,'pendingOrderReject']);
Route::post('/accepted/order/list',[SellerController::class,'acceptedOrderList']);
Route::post('/delivaryman/status',[SellerController::class,'delivaryManStatus']);
Route::post('/assign/delivaryman',[SellerController::class,'assignDelivaryman']);
Route::post('/myassigned/order/list',[DelivarymanController::class,'acceptedOrderList']);
Route::post('/delivary/success',[DelivarymanController::class,'delivarySuccess']);
Route::post('/delivary/order/received',[PatientController::class,'productReceived']);
Route::post('/delivary/paid',[DelivarymanController::class,'delivaryPaid']);

//chat
Route::post('/chat',[CommonController::class,'chat']);
Route::post('/chat/send',[CommonController::class,'chatSubmit']);
Route::post('/chat/read',[DoctorController::class,'chatRead']);
