<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_type;
use App\Models\All_user;
use App\Models\Login_history;
use App\Http\Controllers\MailController;
use App\Models\Chat;



class CommonController extends Controller
{
    
    public function register(){
        $list = User_type::where('type', 'patient')->first();
        return view('All_user.register')->with('types', $list);
    }

    public function loginUser(){
        return view('All_user.login');
    }
    

    public function logout(){
        session()->flush();
        return redirect()->route('loginUser');
    }

    public function loginSubmit(Request $req){
        $req->validate(
            [
                'username'=>'required|exists:all_users,username',
                'password'=>'required',
            ],
            [
                'username.required'=>'please provide a username',
                'username.exists'=>'username does not exists',

            ]
        );
        $user = All_user::where('username', $req->username)->where('password', md5($req->password))->first();
        if ($user){
            $dateNow = date('Y-m-d H:i:s');
            $entry = new Login_history();
            $entry->username = $req->username;
            $entry->login_time = $dateNow;
            $entry->save();

            if($user->is_verified == 0){
                return redirect()->back()->with(session()->flash('alert-danger', 'Username is not verified.'));
            }

            Session()->put('username', $user->username);
            Session()->put('userType', $user->user_types->type);
            session()->flash('alert-success', 'Welcome '.$user->username);

            if((session()->get('userType')) == 'admin'){

                return redirect()->route('admin.homepage');
            }
            if((session()->get('userType')) == 'doctor'){

                return redirect()->route('doctor.homepage');
            }
            if((session()->get('userType')) == 'patient'){

                return redirect()->route('patient.homepage');
            }
            if((session()->get('userType')) == 'seller'){

                return redirect()->route('seller.homepage');
            }
            if((session()->get('userType')) == 'delivaryman'){

                return redirect()->route('delivaryman.homepage');
            }
            

            //return $allUser->user_types->type;
            return $dateNow;

        }
        else {
            return redirect()->back()->with(session()->flash('alert-danger', 'Username and password did not match.'));
        }
    }

    public function userInfo(Request $req){
        $info = All_user::where('username', decrypt($req->username))->first();
        //return $info;
        return view('All_user.userInfo')->with('info', $info);
    }

    public function userProfileEdit(){
        $user = All_user::where('username',session()->get('username'))->first(['name','gender', 'address']);
        //return $user;
        return view('All_user.editProfile')->with('info', $user);
    }

    public function userProfileEditSubmit(Request $req){
        $req->validate(
            [
                'name'=>'required|regex:/^[A-Z a-z.]+$/',
                'gender'=>'required',
                'address'=>'required',
            ]
        );
        
        $user = All_user::where('username', session()->get('username'))->first();
        $user->name = $req->name;
        $user->gender = $req->gender;
        $user->address = $req->address;
        $user->save();
        session()->flash('alert-success', 'Your profile has been edited');
        
        return redirect()->route('user.personal.info', ['username'=>encrypt(session()->get('username'))]);
    }

    public function forgotPassword(){
        return view('All_user.forgotPassword');
    }

    public function forgotPasswordSubmit(Request $req){
        $user = All_user::where('username', $req->username)->first();
        if($user){
            $user->verification_code = sha1($req->username.time());
            $user->save();
            MailController::sendForgotPasswordEmail($user->name, $user->email, $user->verification_code);
            return redirect()->back()->with(session()->flash('alert-success', 'Password change verification has been sent to your email'));
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'Username does not exists'));
    }

    public function resetPassword(Request $req){
        return view('All_user.resetPassword')->with('verification_code', $req->verification_code);
    }

    public function resetPasswordSubmit(Request $req){
        $req->validate(
            [
                'password'=>'required|min:3|max:20',
                'confirmPassword'=>'required|same:password'
            ],
            [
                'confirmPassword.same'=>'New Password and confirm password must be same'
            ]
        );

        $user = All_user::where('verification_code', $req->verification_code)->first();
        if($user){
            $user->password = md5($req->password);
            $user->save();
            return redirect()->route('loginUser')->with(session()->flash('alert-success', 'Password changed successfully. Please login'));
        }
        return redirect()->route('loginUser')->with(session()->flash('alert-danger', 'Something went wrong, please try again.'));

    }

    public function addProfilePicture(){
        return view('All_user.addProfilePicture');
    }

    public function addProfilePictureSubmit(Request $req)
    {
        $req->validate(
            [
            'profile_pic' => 'mimes:jpg,bmp,png,jpeg',
            ]
        );
        $user = All_user::where('username', session()->get('username'))->first();
        if($user){
            $imageName = session()->get('username').time().'.'.$req->file('profile_pic')->getClientOriginalExtension();
            $req->file('profile_pic')->storeAs('public/profile_pics', $imageName);
            $user->profile_pic = "storage/profile_pics/".$imageName;
            $user->save();
            return redirect()->back()->with(session()->flash('alert-success', 'Profile picture successfully uploaded'));
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'Please try again.'));
    }

    public function chat(Request $req){
        $receiverUsername = $req->receiverUsername;
        $receiverInfo = All_user::where('username', $receiverUsername)->first();

        $chat = Chat::where(function ($query) use ($receiverUsername) {
            $query->where('sender', session()->get('username'))
                  ->where('receiver', $receiverUsername);
        })->orWhere(function ($query) use ($receiverUsername) {
            $query->where('receiver', session()->get('username'))
                  ->where('sender', $receiverUsername);
        })->get();

        //return $chat[0]->all_users_s;
        //return $chat;
        return view('All_user.chat')->with('chats', $chat)->with('receiverInfo', $receiverInfo);
    }

    public function chatSubmit(Request $req){
        $req->validate(
            [
            'chatMsg' => 'required',
            ]
        );
        //return $req;
        $chat = new Chat();
        $chat->sender = session()->get('username');
        $chat->receiver = $req->receiverUsername;
        $chat->message = $req->chatMsg;
        $chat->sent_time = date('Y-m-d H:i:s');
        $chat->is_read = 0;
        $chat->save();
        return redirect()->route('chat', ['receiverUsername'=>$chat->receiver]);
        //return $req;
        //return redirect()->route('chat');
    }

    
}
