<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\All_user;
use App\Http\Controllers\MailController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    /*protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    */

    public function register(Request $req){
        $req->validate(
            [
                'name'=>'required|regex:/^[A-Z a-z.]+$/',
                'gender'=>'required',
                'userTypes_id'=>'required',
                'username'=>'required|min:5|max:10|unique:all_users,username',
                'email'=>'required|email|unique:all_users,email',
                'address'=>'required',
                'password'=>'required|min:3|max:20',
                'confirmPassword'=>'required|same:password'
            ],
            [
                'username.required'=>'Please provide username',
                'userTypes_id.required'=>'User Type field is required',
                'confirmPassword.same'=>'Password and confirm password must be same'
            ]
        );
        $user = new All_user();
        $user->username = $req->username;
        $user->password = md5($req->password);
        $user->name = $req->name;
        $user->gender = $req->gender;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->user_types_id = $req->userTypes_id;
        $user->status = 1;
        $user->verification_code = sha1($req->username.time());
        $user->save();

        if($user != null){
            //send email
            MailController::sendSignupEmail($user->name, $user->email, $user->verification_code);

            //show message that tell the user to check their mail for verification link
            return redirect()->back()->with(session()->flash('alert-success', 'your account has been created. Please check email for verification link.'));
        }
        //error message show 
        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong...'));

    }

    public function verifyUser(Request $req){
        $user = All_user::where ('verification_code', $req->verification_code)->first();
        if ($user){
            $user->is_verified = 1;
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->route('loginUser')->with(session()->flash('alert-success', 'Your account is verified, please login'));
        }
        //return redirect()->route('login')->with(session()->flash('alert-danger', 'Invalid verification code'));
        return "not working";
    }
}
