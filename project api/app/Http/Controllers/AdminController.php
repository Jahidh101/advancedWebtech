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
    
    public function addUserType(){
        return view('Users.Admin.addUserType');
    }

    public function addUserTypeSubmit(Request $req){
        $req->validate(
            [
                'userType'=>'required|unique:user_types,type|regex:/^[a-z]+$/',
            ],
            [
                'userType.regex'=>'Usertype can only contain lower case alphabets ',
            ]
        );
        $uTypes = new User_type();
        $uTypes->type = $req->userType;
        $uTypes->save();
        return redirect()->route('admin.UserType.list');
    }

    public function userTypeList(){
        $list = User_type::all();
        return view('Users.Admin.userTypeList')->with('types', $list);
    }

    public function UserTypeEdit(Request $req){
        $list = User_type::where('id',$req->id)->first();
        return view('Users.Admin.editUserType')->with('types', $list);
    }

    public function UserTypeEditSubmit(Request $req){
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
        $uTypes->save();
        return redirect()->route('admin.UserType.list');
    }

    public function addUserForm(){
        $list = User_type::all();
        return view('All_user.register')->with('types', $list);
    }

    public function allLoginHistory(){
        $list = Login_history::all();
        return view('Users.Admin.allLoginHistory')->with('list', $list);
    }

    public function adminHomepage(){
        $doctorsId = User_type::where('type','doctor')->first();
        $patientId = User_type::where('type','patient')->first();
        $countUsers = All_user::where('is_verified',1)->get()->count();
        $countDoctors = All_user::where('is_verified',1)->where('user_types_id', $doctorsId->id)->count();
        $countPatients = All_user::where('is_verified',1)->where('user_types_id', $patientId->id)->count();

        $data = [
            'allVerifiedUsers' => $countUsers,
            'verifiedDoctors' => $countDoctors,
            'verifiedPatients' => $countPatients,

        ];
        return view('Users.Admin.homepage')->with('data', $data);
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
                return redirect()->route('seller.medicine.list')->with(session()->flash('alert-success', 'Medicine '.$prevName. ' updated successfully'));
            }
            return redirect()->back()->with(session()->flash('alert-danger', 'This type of Medicine '.$req->name.' already exists'));
        }
        elseif($req->submitbutton == 'OverWrite'){
            if($medCheck && $medNameCheck){
                $medNameCheck->exists = true;
                $medNameCheck->quantity = $medNameCheck->quantity + $req->quantity;
                $medNameCheck->save();
                $medCheck = Medicine::where('id', $req->id)->delete();
                return redirect()->route('seller.medicine.list')->with(session()->flash('alert-success', 'Medicine '.$prevName. ' has been deleted and it has been added to medicine '.$medNameCheck->name));
            }
            return redirect()->back()->with(session()->flash('alert-danger', 'This type of Medicine '.$req->name.' does not exists to overwrite'));

        }
        
    }

    public function medicinePriceSet(Request $req){
        $medicine = Medicine::where('id', $req->id)->first();
        return view('Users.Admin.medicinePriceSet')->with('medicine', $medicine);
    }

    public function medicinePriceSetSubmit(Request $req){
        $req->validate(
            [
                'pricePerPiece'=>'required|regex:/^[0-9]+$/',
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
                return redirect()->route('seller.medicine.list')->with(session()->flash('alert-success', 'Medicine id = '.$medCheck->id. ', name = '.$medCheck->name.', price has been updated from '.$oldPrice.' taka to '.$req->pricePerPiece.' taka successfully'));
            }
            return redirect()->route('seller.medicine.list')->with(session()->flash('alert-success', 'Medicine id = '.$medCheck->id. ', name = '.$medCheck->name. ', price has been set to '.$req->pricePerPiece.' taka successfully'));
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'This type of Medicine '.$req->name.' already exists'));
    }

    public function medicineBlockedList(){
        $list = Medicine::where('permission', 0)->orderByRaw("concat(name, type, weight)")->get();
        return view('Users.Admin.medicineBlockedList')->with('list', $list);
    }

    public function medicineBlock(Request $req){
        $medCheck = Medicine::where('id', $req->id)->first();
        if($medCheck){
            $medCheck->exists = true;
            $medCheck->permission = 0;
            $medCheck->save();
            return redirect()->route('seller.medicine.list')->with(session()->flash('alert-danger', 'Medicine id = '.$medCheck->id. ', name = '.$medCheck->name. ', has been blocked successfully'));
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'This type of Medicine '.$req->name.' does not exists'));
        
    }

    public function medicineUnblock(Request $req){
        $medCheck = Medicine::where('id', $req->id)->first();
        if($medCheck){
            $medCheck->exists = true;
            $medCheck->permission = 1;
            $medCheck->save();
            return redirect()->route('seller.medicine.list')->with(session()->flash('alert-success', 'Medicine id = '.$medCheck->id. ', name = '.$medCheck->name. ', has been unblocked successfully'));
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'This type of Medicine '.$req->name.' does not exists'));
        
    }

    public function addDelivaryman(){
        return view('Users.Admin.addDelivaryman');
    }

    public function addDelivarymanSubmit(Request $req){
        $req->validate(
            [
                'username'=>'required|unique:delivary_man_info,username|exists:all_users,username',
            ],
            [
                
            ]
        );
        $info = new Delivary_man_info();
        $info->username = $req->username;
        $info->save();
        return redirect()->route('admin.delivaryman.list');
    }

    public function delivarymanList(){
        $list = Delivary_man_info::all();
        return view('Users.Admin.delivarymanList')->with('list', $list);
    }


}
