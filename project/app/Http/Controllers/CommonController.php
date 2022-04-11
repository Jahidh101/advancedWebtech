<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_type;
use App\Models\All_user;
use App\Models\Login_history;
use App\Http\Controllers\MailController;
use App\Models\Chat;
use App\Models\Token;
use Illuminate\Support\Str;
 



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
        //return response()->json($req);
        $user = All_user::where('username', $req->username)->where('password', md5($req->password))->first();
        if ($user){
            //return response()->json($user);
            if($user->is_verified == 0){
                return response()->json(["errorMsg" => "Account is not verified"]);
            }
            $auth_token = Str::random(64);
            $token  = new Token();
            $token->username = $req->username;
            $token->token = $auth_token;
            $token->created_at = date('Y-m-d H:i:s');
            $token->save();
            return response()->json(["successMsg" => "Login successful ", "authToken" =>$auth_token, "userType" => $user->user_types->type]);

            $dateNow = date('Y-m-d H:i:s');
            $entry = new Login_history();
            $entry->username = $req->username;
            $entry->login_time = $dateNow;
            $entry->save();

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
        }
        else {
            return response()->json(["errorMsg" => 'Username and password did not match']);
        }
    }

    public function userInfo(Request $req){
        $info = All_user::where('username', $req->username)->first();
        //return $info;
        return response()->json($info);
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
        
        $user = All_user::where('username', $req->username)->first();
        $user->name = $req->name;
        $user->gender = $req->gender;
        $user->address = $req->address;
        if($user->save())
            return response()->json(["successMsg" => "your profile updated successfully"]);
        
        return response()->json(["errorMsg" => "your profile update failed"]);
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
            return response()->json(["successMsg" => "Password change verification link has been sent to your eamil."]);
        }
        return response()->json(["errorMsg" => "Username does not exists"]);
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
            return response()->json(["successMsg" => "Password changed successfully."]);
        }
        return response()->json(["errorMsg" => "Something went wrong."]);

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
        $user = All_user::where('username', $req->username)->first();
        if($user){
            $imageName = $user->username.time().'.'.$req->file('profile_pic')->getClientOriginalExtension();
            $req->file('profile_pic')->storeAs('public/profile_pics', $imageName);
            $user->profile_pic = "storage/profile_pics/".$imageName;
            $user->save();
            return response()->json(["successMsg" => "your profile pic uploaded successfully"]);
        }
        return response()->json(["errorMsg" => "your profile pic upload failed"]);
    }

    public function chat(Request $req){
        //return response()->json($req);
        $receiverUsername = $req->receiverUsername;
        $username = $req->username;
        $receiverInfo = All_user::where('username', $receiverUsername)->first();
        //return response()->json($receiverUsername);

        $chat = Chat::where(function ($query) use ($receiverUsername, $username) {
            $query->where('sender', $username)
                  ->where('receiver', $receiverUsername);
        })->orWhere(function ($query) use ($receiverUsername, $username) {
            $query->where('receiver', $username)
                  ->where('sender', $receiverUsername);
        })->get();

        return response()->json($chat);
    }

    public function chatSubmit(Request $req){
        $req->validate(
            [
            'chatMsg' => 'required',
            ]
        );
        $chat = new Chat();
        $chat->sender = $req->username;
        $chat->receiver = $req->receiverUsername;
        $chat->message = $req->chatMsg;
        $chat->sent_time = date('Y-m-d H:i:s');
        $chat->is_read = 0;
        $chat->save();
        return response()->json(["successMsg" => "Message sent successfully."]);
    }

    
}
