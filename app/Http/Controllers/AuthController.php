<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function Login(LoginRequest $Request) {
        $HttpStatus = 200;
        $Message = "";
        $Data = [];

        $Rredentials = $Request->validated();

        if (Auth::attempt($Rredentials)) {
            $User = Auth::user();
            $Data["Token"] = $User->createToken('App')->accessToken;
        }else {
            $Message = "Unauthorised";
            $HttpStatus = 401;
        }

        return response()->json([
            "data" => $Data,
            "message" => [$Message]
        ], $HttpStatus);
    }

    public function Logout() {
        $HttpStatus = 200;
        $Data = [];
        
        Auth::user()->tokens()->delete();

        return response()->json([
            "data" => $Data,
            "message" => ["Logout Success"]
        ], $HttpStatus);
    }

    public function WhoAmI() {
        $User = Auth::user();

        return response()->json([
            "data" => $User,
            "message" => []
        ], 200);
    }
}
