<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\User;
use App\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;




use App\Mail\ForgotEmail;

use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|alpha|max:50',
           
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'same:password',
            
           
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'failed',
                'message' => $validator->errors()
            ],400);
        }

        $data = [
            "name" =>$request->firstname,
            "email" => $request->email,
            "password"=> Hash::make($request->password),
        ];

        $user = User::create($data);

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'status' => "success",
            'token' => $token,
            'user'=>$user,
        ]);

    }

    //login

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            
           
            'email' => 'required|string|email:rfc,dns|max:255|exists:users,email',
            
            'password' => 'required|string|min:8',
           
           
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'failed',
                'message' => "Email address not registered"
            ],400);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => "failed",
                'message' => 'Email & Password does not match with our record.',
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user'=>$user,
        ], 200);

    }



    public function user(Request $request){
        return $request->user();
    }


    //forgot password

    public function forgotpassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email:rfc,dns|max:255|exists:users,email'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => $validator->errors(),
                'msg' => "User email not Registered",
              
            ], 400);
        }

        $tokens = ResetPassword::where("email",$request->email)->first();

        if ($tokens) {
            $tokens->delete();
        }

        $min = 100000;
        $max = 999999;

        $rand  = rand($min, $max);

        $code = (string) $rand;

        $reset = new ResetPassword;

        $reset->email = $request->email;
        $reset->code = $code;
        $reset->save();


        Mail::to("edidiongbobso@gmail.com")->send(new ForgotEmail($code));

        return response()->json([
            'status' => 'success',
            'email' => $request->email
        ]);
        


    }


    //Reset Password 

    public function resetpassword(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'password' => 'required',
            'email' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response([
                'status' => "failed",
                'message' => $validator->errors(),
                'msg' => "User email not Registered",
              
            ], 400);
        }

        $pass = ResetPassword::where("code",$request->code)->first();

        if(!$pass){
            return [
                'status' => "failed",
                'message' => "Invalid token code, kindly input a valid token"
            ];
        }

        if ($pass->email != $request->email) {
            return [
                    'status' => 'failed',
                    'message' => 'That code was not generated for the specified account'
                
                ];
        }

        if (time() > (strtotime($pass->created_at) + (60 * 60))) {
            return [
                'status' => "invalid",
                    'message' => "Sorry that code has expired"
                
            ];
        }



        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            "user" => $user
        ]);

    }
}
