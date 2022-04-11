<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_type;
use App\Models\All_user;
use App\Models\Login_history;
use App\Models\Medicine;
use App\Models\Medicine_type;
use App\Models\Delivary_man_info;

class AdminController extends Controller
{

    public function addUserTypeSubmit(Request $req){
        $req->validate(
            [
                'userType'=>'required|regex:/^[a-z]+$/',
            ],
            [
                'userType.regex'=>'Usertype can only contain lower case alphabets ',
            ]
        );
        $type = User_type::where('type', $req->userType)->first();
        if($type)
            return response()->json(["errorMsg" => "userType already exists"]);
        $uTypes = new User_type();
        $uTypes->type = $req->userType;
        if($uTypes->save())
            return response()->json(["successMsg" => "userType added successfully"]);
        return response()->json(["errorMsg" => "userType add failed"]);
    }

    public function userTypeList(){
        $list = User_type::all();
        return response()->json($list);
    }

    public function getUserType(Request $req){
        $userType = User_type::where('id',$req->id)->first();
        return response()->json($userType);
    }

    public function userTypeEditSubmit(Request $req){
        $req->validate(
            [
                'userType'=>'required|unique:user_types,type|regex:/^[a-z]+$/',
            ],
            [
                'userType.regex'=>'Usertype can only contain lower case alphabets',
            ]
        );
        $uTypes = new User_type();
        $uTypes->exists = true;
        $uTypes->id = $req->id;
        $uTypes->type = $req->userType;
        if($uTypes->save())
            return response()->json(["successMsg" => "userType edited successfully"]);
        return response()->json(["errorMsg" => "userType edit failed"]);
    }

    public function addUserForm(){
        $list = User_type::all();
        return view('All_user.register')->with('types', $list);
    }

    public function allLoginHistory(){
        $list = Login_history::all();
        return response()->json($list);
    }

    public function adminHomepage(){
        $doctorsId = User_type::where('type','doctor')->first();
        $patientId = User_type::where('type','patient')->first();
        $sellerId = User_type::where('type','seller')->first();
        $delivarymanId = User_type::where('type','delivaryman')->first();
        $countUsers = All_user::where('is_verified',1)->get()->count();
        $countDoctors = All_user::where('is_verified',1)->where('user_types_id', $doctorsId->id)->count();
        $countPatients = All_user::where('is_verified',1)->where('user_types_id', $patientId->id)->count();
        $countSellers = All_user::where('is_verified',1)->where('user_types_id', $sellerId->id)->count();
        $countDelivarymen = All_user::where('is_verified',1)->where('user_types_id', $delivarymanId->id)->count();

        $data = [
            'allVerifiedUsers' => $countUsers,
            'verifiedDoctors' => $countDoctors,
            'verifiedPatients' => $countPatients,
            'verifiedSellers' => $countSellers,
            'verifiedDelivarymen' => $countDelivarymen,
        ];
        return response()->json($data);
    }

    public function newMedicineList(){
        $list = Medicine::where('price_per_piece', null)->get();
        return view('Users.Admin.newMedicineList')->with('list', $list);
    }

    public function medicineEdit(Request $req){
        $types = Medicine_type::all();
        $medicine = Medicine::where('id', $req->id)->first();
        return view('Users.Admin.MedicineEdit')->with('medicine', $medicine)->with('types', $types);
    }

    public function medicineEditSubmit(Request $req){
        $req->validate(
            [
                'name'=>'required|regex:/^[A-Za-z]+$/',
                'medicineType'=>'required',
                'weight'=>'required|regex:/^[a-z0-9 ]+$/',
                'quantity'=>'required|regex:/^[0-9]+$/',
            ],
            [
                'name.regex'=>'Type can only contain lower case alphabets. ',
                'quantity.regex'=>'Quantity can only contain numbers.',
            ]
        );

        $medCheck = Medicine::where('id', $req->id)->first();
        $prevName = $medCheck->name;
        $medNameCheck = Medicine::where('name', $req->name)->where('type', $req->medicineType)->where('weight', $req->weight)->where('id','<>', $req->id)->first();
        if($req->submitbutton == 'Update'){
            if($medCheck && !$medNameCheck){
                $medCheck->exists = true;
                $medCheck->name = $req->name;
                $medCheck->type = $req->medicineType;
                $medCheck->weight = $req->weight;
                $medCheck->quantity = $req->quantity;
                $medCheck->save();
                return response()->json(["successMsg" => "Medicine name " .$prevName. " updated successfully"]);
            }
            return response()->json(["errorMsg" => "This type of Medicine " .$req->name. " already exists"]);
        }
        elseif($req->submitbutton == 'OverWrite'){
            if($medCheck && $medNameCheck){
                $medNameCheck->exists = true;
                $medNameCheck->quantity = $medNameCheck->quantity + $req->quantity;
                $medNameCheck->save();
                $medCheck = Medicine::where('id', $req->id)->delete();
                return response()->json(["successMsg" => "Medicine " .$prevName. " has been deleted and it has been added to medicine " .$medNameCheck->name]);
            }
            return response()->json(["errorMsg" => "This type of Medicine " .$req->name. " does not exists to overwrite"]);
        }
        
    }

    public function medicinePriceSet(Request $req){
        $medicine = Medicine::where('id', $req->id)->first();
        return view('Users.Admin.medicinePriceSet')->with('medicine', $medicine);
    }

    public function medicinePriceSetSubmit(Request $req){
        $req->validate(
            [
                'pricePerPiece'=>'required|regex:/^[0-9.]+$/',
            ],
            [
                'pricePerPiece.regex'=>'price Per Piece can only contain numbers.',
            ]
        );

        $medCheck = Medicine::where('id', $req->id)->first();
        $oldPrice = $medCheck->price_per_piece;
        if($medCheck){
            $medCheck->exists = true;
            $medCheck->price_per_piece = $req->pricePerPiece;
            $medCheck->save();
            if($oldPrice){
                return response()->json(["successMsg" => 'Medicine id = '.$medCheck->id. ', name = '.$medCheck->name.', price has been updated from '.$oldPrice.' taka to '.$req->pricePerPiece.' taka successfully']);
            }
            return response()->json(["successMsg" => 'Medicine id = '.$medCheck->id. ', name = '.$medCheck->name. ', price has been set to '.$req->pricePerPiece.' taka successfully']);
        }
        return response()->json(["errorMsg" => "This Medicine does not exists."]);
    }

    public function medicineBlockedList(){
        $list = Medicine::where('permission', 0)->orderByRaw("concat(name, type, weight)")->get();
        return response()->json($list);
    }

    public function medicineBlock(Request $req){
        $medCheck = Medicine::where('id', $req->id)->first();
        if($medCheck){
            $medCheck->exists = true;
            $medCheck->permission = 0;
            $medCheck->save();
            return response()->json(["successMsg" => 'Medicine id = '.$medCheck->id.' blocked successfully']);
        }
        return response()->json(["errorMsg" => "This Medicine does not exists."]);
        
    }

    public function medicineUnblock(Request $req){
        $medCheck = Medicine::where('id', $req->id)->first();
        if($medCheck){
            $medCheck->exists = true;
            $medCheck->permission = 1;
            $medCheck->save();
            return response()->json(["successMsg" => 'Medicine id = '.$medCheck->id.' unblocked successfully']);
        }
        return response()->json(["errorMsg" => "This Medicine does not exists."]);
        
    }

    public function addDelivaryman(){
        return view('Users.Admin.addDelivaryman');
    }

    public function addDelivarymanSubmit(Request $req){
        $req->validate(
            [
                'username'=>'required',
            ],
            [
                
            ]
        );
        $existingUser = Delivary_man_info::where('username', $req->username)->first();
        if($existingUser)
            return response()->json(["errorMsg" => "This username already exists"]);;
        $userType = User_type::where('type', 'delivaryman')->first();
        $user = All_user::where('username', $req->username)->where('user_types_id', $userType->id)->first();
        if($user){
            $info = new Delivary_man_info();
            $info->username = $req->username;
            if($info->save())
                return response()->json(["successMsg" => "delivaryman added successfully"]);
        }
        return response()->json(["errorMsg" => "This username is not for a delivary man"]);
    }

    public function delivarymanList(){
        $list = Delivary_man_info::all();
        return response()->json($list);
    }

    public function delivarymanInfo(Request $req){
        $info = Delivary_man_info::where('username',  $req->username)->first();
        return response()->json($info);
    }

    public function doctorList(){
        $list = All_user::where('user_types_id', 2)->where('is_verified', 1)->get();
        return response()->json($list);
    }

    public function patientList(){
        $list = All_user::where('user_types_id', 3)->where('is_verified', 1)->get();
        return response()->json($list);
    }

    public function medicineList(){
        $newList = Medicine::where('price_per_piece', null)->where('permission', 1)->orderByRaw("concat(name, type, weight)")->get();
        $oldList = Medicine::where('price_per_piece', '<>', null)->where('permission', 1)->orderByRaw("concat(name, type, weight)")->get();
        $list = [
            "newList" => $newList,
            "oldList" => $oldList,
        ];
        return response()->json($list);
    }

    public function medicineGet(Request $req){
        $medicine = Medicine::where('id', $req->id)->first();
        return response()->json($medicine);
    }




}
