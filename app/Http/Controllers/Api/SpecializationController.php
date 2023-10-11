<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Collage;
use App\Http\Requests\SpecializationRequest;
use Illuminate\Http\Request;
use App\Http\Resources\SpecializationResource;

class SpecializationController extends Controller
{
    use JsonResponse;

    public function index(){
        $specializations=Specialization::all();
        return $this->successResponse('All Specializations',SpecializationResource::collection($specializations));
    }

    public function getByCollage($id){
        $collage=Collage::where('id',$id)->first();
        $object=$collage->specializations()->get();
        return $this->successResponse('Get Specializations By Collage',SpecializationResource::collection($object));
    }

    public function searchBySpecialization(Request $request){
        $specialization=Specialization::where('specialization_name','like','%'.$request->specialization_name.'%')->get();
        if(!$specialization->isEmpty()){
            return $this->successResponse('Search By Specialization',SpecializationResource::collection($specialization));
        }
        return $this->notFoundResponse('Specialization Not Found');
    }

    public function store(SpecializationRequest $request){
        if($request->hasFile('image')){
            $imagePath=$request->file('image')->store('public/images');
        }
        $specialization=Specialization::create([
            'specialization_name'=> $request->specialization_name,
            'image'=>$imagePath,
            'collage_id'=>$request->collage_id
        ]);

        return $this->successResponse('Specialization Created Successfully');

    }

    public function update(SpecializationRequest $request,$id) {
        try {
            $specialization = Specialization::findOrFail($id);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
        }
        $res = $specialization->update([
            'specialization_name' => $request->input('specialization_name') ?? $specialization->specialization_name,
            'image' => $imagePath ?? $specialization->image,
            'collage_id' => $request->input('collage_id') ?? $specialization->collage_id
        ]);

        return $this->successResponse('Updated Specialization successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }

    }


    public function destroy($sid){
        try {
            $specialization = Specialization::findOrFail($sid);
            $specialization->delete();

            return $this->successResponse('Deleted Specialization Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }
    }

    public function CheckButtons(){
        $code = auth()->user()->code;
        $id = $code->specialization_id;
        $specialization = Specialization::FindOrFail($id);
        if($specialization->has_levels==true){

            return $this->successResponse('Show Buttons',true);
        }
        return $this->successResponse('Hide Buttons',false);
    }
}
