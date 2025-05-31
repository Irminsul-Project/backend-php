<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormStandart extends FormRequest
{
    protected $stopOnFirstFailure = true;

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'data' => (object)[],
            'message' => [$validator->errors()->first()]
        ], 422));
    }
}
