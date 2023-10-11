<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonResponseTrait
{
    protected function failedValidation(Validator $validator)
{
    $errors = [];
    foreach ($validator->errors()->toArray() as $field => $messages) {
        $errors[$field] = reset($messages);
    }
    
    $formattedErrors = [];
    foreach ($errors as $field => $message) {
        $formattedErrors[$field] = $message;
    }
    
    throw new HttpResponseException(response()->json([
        'code' => 422,
        'status' => false,
        'errors' => $formattedErrors,
    ], 400));
}
}
