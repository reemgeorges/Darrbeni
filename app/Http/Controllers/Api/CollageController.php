<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collage;
use App\Http\Resources\CollageResource;

class CollageController extends Controller
{
    use JsonResponse;

    public function index(){
        $collages=Collage::all();
        return $this->successResponse('All collages',CollageResource::collection($collages));
    }

    public function getCollagesWithSpecialization(){
        $specializations=Collage::with('specializations')->get();
        return $this->successResponse('Collages with their Specializations',$specializations);
    }

}
