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

    public function patientList(Request $req){
        $unreadChatUname = Chat::where('receiver', $req->username)->where('is_read', 0)->distinct('sender')->pluck('sender');
        $readChatUname = Chat::where('receiver', $req->username)->where('is_read', 1)->distinct('sender')->pluck('sender');
        //return response()->json($readChatUname);
        $allChat = All_user::where('user_types_id', 3)->where('is_verified', 1)->get();
        $unreadChat = array();
        $readChat = array();
        foreach ($unreadChatUname as $uc){
            //return response()->json($uc);
            $patientUnread = All_user::where('username', $uc)->first();
            //return response()->json($doctorUnread);
            $unreadChat[] = $patientUnread;
        }

        foreach ($readChatUname as $rc){
            //return response()->json($uc);
            $patientRead = All_user::where('username', $rc)->first();
            //return response()->json($doctorUnread);
            $readChat[] = $patientRead;
        }

        //return response()->json($readChat);

        $patients = [
            'unreadChat' => $unreadChat,
            'readChat' => $readChat,
            'allChat' => $allChat,
        ];
        return response()->json($patients);
    }


    public function chatRead(Request $req){
        $chatRead = Chat::where('sender', $req->receiverUsername)->where('receiver', $req->username)->update(['is_read' => 1]);
        return response()->json(["successMsg" => "Message read successfully."]);
    }
}


