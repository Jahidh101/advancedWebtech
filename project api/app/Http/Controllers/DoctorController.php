<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\All_user;

class DoctorController extends Controller
{
    public function doctorHomepage(){
        return view('Users.Doctor.homepage');
    }

    public function patientList(){
        $unreadChat = Chat::where('receiver',session()->get('username'))->where('is_read', 0)->distinct('sender')->pluck('sender');
        $readChat = Chat::where('receiver',session()->get('username'))->where('is_read', 1)->distinct('sender')->pluck('sender');
        
        //return $unreadChat->count();
        $info = All_user::where('user_types_id', 3)->where('is_verified', 1)->get();
        //return $info;
        return view('Users.Doctor.patientList')->with('infoAll', $info)->with('unreadChat', $unreadChat)->with('readChat', $readChat);
    }

    public function chatRead(Request $req){
        $chatRead = Chat::where('sender', $req->receiverUsername)->where('receiver', session()->get('username'))->update(['is_read' => 1]);
        //return $chatRead;
        //return $req->receiverUsername;
        return redirect()->route('chat', ['receiverUsername'=>$req->receiverUsername]);
    }
}


