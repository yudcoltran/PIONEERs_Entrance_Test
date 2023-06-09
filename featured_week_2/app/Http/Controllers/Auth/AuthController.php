<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(), [
            'name'=>'required|max:255',
            'email'=>'required|email|max:255|unique:users',
            'password'=>'required|min:6|confirmed',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password'=>Hash::make($request->password),
            ]);
        }
        $token = JWTAuth::fromUser($user);
        if($user) {
            return response()->json([
                'status'=>200,
                'user'=>$user,
                'token'=>$token,
                'message'=>'User registered!!'
            ], 200);
        }else {
            return response()->json([
                'status'=>500,
                'message'=>'Oops, something went wrong!!'
            ], 500);
        }
    }

    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        $token = null;

        try {
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'error'=>'invalid email or password'
                ], 422);
            };
        }catch(JWTException $e) {
            return response()->json([
                'error'=>'Oops something went wrong!!'
            ], 500);
        }

        return response()->json([
            'message' => 'Login success!!',
            'token' => $token
        ]);
    }
}
