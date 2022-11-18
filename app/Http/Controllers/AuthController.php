<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;


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
                'message' => $validator->errors()
            ],400);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
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
}
