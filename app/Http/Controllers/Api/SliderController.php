<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;

class SliderController extends Controller
{
    use JsonResponse;

    public function index(){
        $sliders=Slider::all();
        return $this->successResponse('All Sliders',SliderResource::collection($sliders));
    }

    public function store(SliderRequest $request){
        try {
            $slider=Slider::create([
                'image_url'=>$request->image_url,
                'link'=>$request->link
            ]);
            return $this->successResponse('Slider added Successfully');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(SliderRequest $request,$id){
        try {
            $slider = Slider::findOrFail($id);

            $res = $slider->update([
                'image_url'=>$request->image_url ?? $slider->image_url,
                'link'=>$request->link ?? $slider->link
            ]);

            return $this->successResponse('Updated Slider Successfully');
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }
    }

    public function destroy($id){
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete();

            return $this->successResponse('Slider deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }
}
