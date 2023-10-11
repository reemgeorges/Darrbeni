<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Question;
use App\Models\Importance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\JsonResponseTrait;
use App\Http\Controllers\Api\JsonResponse;
use App\Http\Controllers\Api\JsonResponse as ApiJsonResponse;
use App\Http\Resources\QuestionResource;

class ImportanceController extends Controller
{
    use JsonResponse;

    public function addImportance($qid){
        try{
            $user=Auth::user();
            $question=Question::FindOrFail($qid);
            $importance = Importance::where('user_id', $user->id)->where('question_id', $question->id)->first();
            if($importance){
                return $this->successResponse('Importance already exists');
            }
            Importance::create([
                'user_id'=>$user->id,
                'question_id'=>$question->id
            ]);
            return $this->successResponse('Added To Impotance Successfully');
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function getImportances(){
        $user=Auth::user();
        $importances=$user->questions()->with('answers')->get();
        if($importances->isEmpty()){
            return $this->notFoundResponse('Your Importance Questions Table is empty');
        }
        return $this->successResponse('All Importance Questions',QuestionResource::collection($importances));
    }

    public function removeImportance($qid){
        try{
            $user=Auth::user();
            $question=Question::FindOrFail($qid);
            $user->questions()->detach($question->id);
            return $this->successResponse('Remove From Impotance Successfully');
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }
}
