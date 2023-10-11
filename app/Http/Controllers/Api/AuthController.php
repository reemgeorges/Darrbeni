<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\SpecializationResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Code;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    use JsonResponse;

    public function register(Request $request)
    {
        $user = User::where('mobile_phone', $request->mobile_phone)->first();
    
        if ($user) {
            $newCode = Code::create([
                'user_id' => $user->id,
                'login_code' => Str::random(6, '1234567890'),
                'specialization_id' => $request->specialization_id,
            ]);
    
            return $this->successResponse('Specialization ID Updated Successfully', ['login_code' => $newCode->login_code]);
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'mobile_phone' => 'required|string|regex:/^09[0-9]{8}$/',
            'specialization_id' => 'required|integer|exists:specializations,id',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new HttpResponseException(response()->json([
                'code' => 422,
                'status' => false,
                'errors' => $errors,
            ], 400));
        }
    
        $user = User::create([
            'name' => $request->name,
            'mobile_phone' => $request->mobile_phone,
        ]);
    
        $code = Code::create([
            'user_id' => $user->id,
            'login_code' => Str::random(6, '1234567890'),
            'specialization_id' => $request->specialization_id,
        ]);
    
        $token = $user->createToken('ApiToken')->plainTextToken;
    
        return $this->successResponse('User Registered Successfully', ['token' => $token, 'login_code' => $code->login_code]);
    }


    public function login(LoginRequest $request)
{
    $credentials = $request->only('name', 'login_code');

    $user = User::where('name', $credentials['name'])->first();

    if ($user) {
        $matchingCode = $user->code()->where('login_code', $credentials['login_code'])->first();

        if ($matchingCode) {
            $token = $user->createToken('ApiToken')->plainTextToken;
            $user->update(['fcm_token' => $request->fcm_token]);

            // Get the specialization resource
            $specialization = $matchingCode->specialization;

            return $this->successResponse('Login Success', [
                'token' => $token,
                'specialization' => new SpecializationResource($specialization)
            ]);
        }
    }

    // Handle login failure
    return $this->errorResponse('Invalid credentials');
}

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        auth()->user()->update(['fcm_token' => null]);
        return $this->successResponse('user logged out');
    }
}
