<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormStandart;

class LoginRequest extends FormStandart
{
    public function rules(): array
    {
        return [
            "email" => ["required", 'email'],
            "password" => ["required"]
        ];
    }
}
