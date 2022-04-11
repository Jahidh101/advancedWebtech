<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupEmail;
use App\Mail\ForgotPasswordEmail;

class MailController extends Controller
{
    public static function sendSignupEmail($name, $email, $verification_code){
        $data =[
            'name' => $name,
            'verification_code' => $verification_code
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }

    public static function sendForgotPasswordEmail($name, $email, $verification_code){
        $data =[
            'name' => $name,
            'verification_code' => $verification_code
        ];
        Mail::to($email)->send(new ForgotPasswordEmail($data));
    }

    public function loginUser(){
        return view('All_user.login');
    }

    public function register(){
        return view('All_user.register');
    }
}
