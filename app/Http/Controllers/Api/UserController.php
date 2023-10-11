<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use JsonResponse;

    public function getInfo(){
        $user = auth()->user();
        $data['name']=$user->name;
        $data['mobile_phone']=$user->mobile_phone;
        return $this->successResponse('Profile Info',$data);
    }

    public function update(Request $request){

        $user = auth()->user();

        $user->update([
            'name'=>$request->name ?? $user->name,
            'mobile_phone'=>$request->mobile_phone ?? $user->mobile_phone,
        ]);

        return $this->successResponse('Updated Profile Successfully', (object)[]);
    }

    public function destroy(){
        $user=auth()->user();
        $user->tokens()->delete();
        $user->delete();
        return $this->successResponse('Your Account Deleted');
    }
}
