<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        // validation
        $error = Validator::make($request->all(),[
            "first_name" => "required|string",
            "last_name" => "required|string",
            "phone" => "string",
            "email" => "required|email",
            "password" => "required|confirmed|min:8"
        ]);
        // check errors
        if ($error->fails()) {
            return response()->json([
                "errors" => $error->errors()
            ],303);
        }

        // bcrypt passsword and make access token
        $password=bcrypt($request->password);
        $access_token=Str::random(64);
        // create user
        User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "phone" => $request->phone,
            "email" => $request->email ,
            "password" => $password,
            "access_tpken" => $access_token
        ]);

        return response()->json([
            "message" => "user created successfully",
            "access_token" => $access_token
        ],200);

    }
    public function login(Request $request) {
        $error = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|min:8|string"
        ]);
        // check error
        if ($error->fails()) {
            return response()->json([
                "errors" =>$error->errors()
            ],303);
        }

        $user = User::where("email",$request->email)->first();

        if ($user) {
            $isvalid=Hash::check($request->password,$user->password);
            $access_token = Str::random(64);
            if ($isvalid) {

                $user->update([
                    "access_token" => $access_token
                ]);


                return response()->json([
                    "message" => "login success",
                    "access_token" => $access_token
                ],201);
            }else {
                return response()->json([
                    "message" => "password not correct",
                ],301);
            }
        }else {
            return response()->json([
                "messge" => "email not correct"
            ],303);
        }
    }
    public function logout(Request $request) {
        $access_token=$request->header("access_token");
        if ($access_token) {
            $user = User::where("access_token",$access_token)->first();
            if ($user) {
                $user->update([
                    "access_token"=>null
                ]);
                return response()->json([
                    "message" => "logout succesfully"
                ]);
            }else {
                return response()->json([
                    "message" => "access token not found"
                ],404);
            }
        }else {
            return response()->json([
                "message" => "please enter access token"
            ],301);
        }
    }
}
