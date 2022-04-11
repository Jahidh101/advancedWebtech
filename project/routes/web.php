<?php

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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//user type add edit
//Route::get('/addUserType',[AdminController::class,'addUserType'])->name('admin.addUserType')->middleware('adminAuth');
//Route::post('/addUserType',[AdminController::class,'addUserTypeSubmit'])->name('admin.addUserType.submit')->middleware('adminAuth');
//Route::get('/UserType/edit',[AdminController::class,'UserTypeEdit'])->name('admin.UserType.edit')->middleware('adminAuth');
//Route::post('/UserType/edit',[AdminController::class,'UserTypeEditSubmit'])->name('admin.UserType.edit.submit')->middleware('adminAuth');
//Route::get('/getUserType/list',[AdminController::class,'userTypeList'])->name('admin.UserType.list')->middleware('adminAuth');

//all_user add edit
//Route::get('/addUser',[AdminController::class,'addUserForm'])->name('admin.addUser.form')->middleware('adminAuth');
//Route::post('/addUser',[RegisterController::class, 'register'])->name('admin.addUser')->middleware('adminAuth');
//Route::get('/user/info/{username}',[CommonController::class,'userInfo'])->name('user.personal.info')->middleware('commonAuth');
//Route::get('/UserProfile/edit',[CommonController::class,'userProfileEdit'])->name('user.profile.edit')->middleware('commonAuth');
//Route::post('/UserProfile/edit',[CommonController::class,'userProfileEditSubmit'])->name('user.profile.edit')->middleware('commonAuth');
//Route::get('/add/profilePicture',[CommonController::class,'addProfilePicture'])->name('add.profile.picture')->middleware('commonAuth');
//Route::post('/add/profilePicture',[CommonController::class,'addProfilePictureSubmit'])->name('add.profile.picture')->middleware('commonAuth');

//login
//Route::get('/login/user', [CommonController::class,'loginUser'])->name('loginUser');
//Route::post('/login/user',[CommonController::class,'loginSubmit'])->name('loginUser');
//Route::get('/login/history',[AdminController::class,'allLoginHistory'])->name('admin.login.history.all')->middleware('adminAuth');
//Route::get('/logout', [CommonController::class,'logout'])->name('logout')->middleware('commonAuth');
//Route::get('/forgot/password', [CommonController::class,'forgotPassword'])->name('forgot.password');
//Route::post('/forgot/password', [CommonController::class,'forgotPasswordSubmit'])->name('forgot.password');
//Route::get('/reset/password', [CommonController::class,'resetPassword'])->name('reset.password');
//Route::post('/reset/password', [CommonController::class,'resetPasswordSubmit'])->name('reset.password');

//redirect aftter login
//Route::get('/homepage',[AdminController::class,'adminHomepage'])->name('admin.homepage')->middleware('adminAuth');
Route::get('/homepage/doctor',[DoctorController::class,'doctorHomepage'])->name('doctor.homepage')->middleware('doctorAuth');
Route::get('/homepage/patient',[PatientController::class,'patientHomepage'])->name('patient.homepage')->middleware('patientAuth');
Route::get('/homepage/seller',[SellerController::class,'sellerHomepage'])->name('seller.homepage')->middleware('sellerAuth');
Route::get('/homepage/delivaryman',[DelivarymanController::class,'delivarymanHomepage'])->name('delivaryman.homepage');

//doctor
//Route::get('/doctor/list',[PatientController::class,'doctorList'])->name('patient.doctorList')->middleware('patientAuth');

//patient
//Route::get('/patient/list',[DoctorController::class,'patientList'])->name('doctor.patientList')->middleware('commonAuth');

//seller

//medicine & diseases
//Route::get('/medicineType/list',[SellerController::class,'medicineTypeList'])->name('seller.medicineType.list')->middleware('sellerAuth');
//Route::get('/medicineType/add',[SellerController::class,'addMedicineType'])->name('seller.medicineType.add')->middleware('sellerAuth');
//Route::post('/medicineType/add',[SellerController::class,'addMedicineTypeSubmit'])->name('seller.medicineType.add')->middleware('sellerAuth');
//Route::get('/medicineType/edit',[SellerController::class,'medicineTypeEdit'])->name('seller.medicineType.edit')->middleware('sellerAuth');
//Route::post('/medicineType/edit',[SellerController::class,'medicineTypeEditSubmit'])->name('seller.medicineType.edit')->middleware('sellerAuth');
//Route::get('/medicine/add',[SellerController::class,'addMedicine'])->name('seller.medicine.add')->middleware('sellerAuth');
//Route::post('/medicine/add',[SellerController::class,'addMedicineSubmit'])->name('seller.medicine.add')->middleware('sellerAuth');
//Route::get('/medicine/list',[SellerController::class,'medicineList'])->name('seller.medicine.list')->middleware('commonAuth');
//Route::get('/medicine/edit',[AdminController::class,'medicineEdit'])->name('admin.medicine.edit')->middleware('adminAuth');
//Route::post('/medicine/edit',[AdminController::class,'medicineEditSubmit'])->name('admin.medicine.edit')->middleware('adminAuth');
Route::get('/medicine/price/set',[AdminController::class,'medicinePriceSet'])->name('admin.medicine.price.set')->middleware('adminAuth');
//Route::post('/medicine/price/set',[AdminController::class,'medicinePriceSetSubmit'])->name('admin.medicine.price.set')->middleware('adminAuth');
//Route::get('/medicine/blocked/list',[AdminController::class,'medicineBlockedList'])->name('admin.medicine.blocked.list')->middleware('adminAuth');
//Route::get('/medicine/block',[AdminController::class,'medicineBlock'])->name('admin.medicine.block')->middleware('adminAuth');
//Route::get('/medicine/unblock',[AdminController::class,'medicineUnblock'])->name('admin.medicine.unblock')->middleware('adminAuth');
//Route::post('/medicine/add/cart',[PatientController::class,'medicineAddToCart'])->name('patient.medicine.addToCart')->middleware('patientAuth');
//Route::get('/medicine/mycart',[PatientController::class,'myCart'])->name('patient.myCart')->middleware('patientAuth');
//Route::get('/medicine/mycart/delete',[PatientController::class,'myCartDelete'])->name('patient.myCart.delete')->middleware('patientAuth');
//Route::get('/medicine/mycart/confirm/order',[PatientController::class,'myCartConfirmOrder'])->name('patient.myCart.confirm.order')->middleware('patientAuth');
//Route::get('/myorder/list',[PatientController::class,'myOrderList'])->name('patient.myOrder.list')->middleware('patientAuth');
//Route::get('/pending/order/list',[SellerController::class,'pendingOrderList'])->name('seller.pending.order.list')->middleware('sellerAuth');
//Route::get('/pending/order/accept',[SellerController::class,'pendingOrderAccept'])->name('seller.pending.order.accept')->middleware('sellerAuth');
//Route::get('/pending/order/reject',[SellerController::class,'pendingOrderReject'])->name('seller.pending.order.reject')->middleware('sellerAuth');
//Route::get('/accepted/order/list',[SellerController::class,'acceptedOrderList'])->name('seller.acceptedOrder.list')->middleware('sellerAuth');
//Route::get('/myassigned/order/list',[DelivarymanController::class,'acceptedOrderList'])->name('delivaryman.acceptedOrder.list');
//Route::get('/delivary/success',[DelivarymanController::class,'delivarySuccess'])->name('delivaryman.delivary.success');
//Route::get('/delivary/order/received',[PatientController::class,'productReceived'])->name('patient.product.received');
//Route::get('/delivary/paid',[DelivarymanController::class,'delivaryPaid'])->name('delivaryman.delivary.paid');


//delivaryman
//Route::get('/add/delivaryman',[AdminController::class,'addDelivaryman'])->name('admin.addDelivaryman')->middleware('adminAuth');
//Route::post('/add/delivaryman',[AdminController::class,'addDelivarymanSubmit'])->name('admin.addDelivaryman')->middleware('adminAuth');
//Route::get('/delivaryman/list',[AdminController::class,'delivarymanList'])->name('admin.delivaryman.list')->middleware('adminAuth');
//Route::post('/assign/delivaryman',[SellerController::class,'assignDelivaryman'])->name('seller.delivaryman.assign')->middleware('sellerAuth');
//Route::post('/delivaryman/status',[SellerController::class,'delivaryManStatus'])->name('seller.delivaryman.status')->middleware('sellerAuth');
//Route::get('/seller/delivaryman/list',[SellerController::class,'delivarymanList'])->name('seller.delivaryman.list')->middleware('sellerAuth');

//chat
//Route::get('/chat',[CommonController::class,'chat'])->name('chat')->middleware('commonAuth');
//Route::post('/chat',[CommonController::class,'chatSubmit'])->name('chat')->middleware('commonAuth');
//Route::get('/chat/read',[DoctorController::class,'chatRead'])->name('doctor.chat.read')->middleware('commonAuth');

Auth::routes();

//email verify
//Route::get('/verify', [RegisterController::class, 'verifyUser'])->name('verify.email');
//Route::get('/register', [CommonController::class, 'register'])->name('register');
//Route::post('/register', [RegisterController::class, 'register'])->name('register');

//medicine






Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
