<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            "Data" => $Data,
            "Message" => $Message
        ], $HttpStatus);
    }

    public function WhoAmI() {
        $User = Auth::user();

        return response()->json([
            "Data" => $User,
            "Message" => ""
        ], 200);
    }
}
