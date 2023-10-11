<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Term;
use App\Models\Answer;
use App\Models\Specialization;
use App\Models\Subject;
use App\Http\Controllers\Api\JsonResponse;
use App\Http\Resources\QuestionAnswerTermResource;
use App\Http\Resources\QuestionResource;
use Exception;

class QuestionController extends Controller
{
    use JsonResponse;

    public function store(QuestionRequest $request){
        // try {

            $question=Question::create([
                'question_content'=>$request->question_content,
                'reference'=>$request->reference,
                'subject_id'=>$request->subject_id,
                'term_id'=>$request->term_id,
                'specialization_id'=>$request->specialization_id
            ]);
            return $this->successResponse('Question added Successfully');
        // } catch (Exception $e) {
        //     return $this->handleException($e);
        // }
    }

    public function update(QuestionRequest $request,$id){
        try {
            $question = Question::findOrFail($id);

            $res = $question->update([
                'question_content'=>$request->question_content ?? $question->question_content,
                'reference'=>$request->reference ?? $question->reference,
                'subject_id'=>$request->subject_id ?? $question->subject_id,
                'term_id'=>$request->term_id ?? $question->term_id
            ]);

            return $this->successResponse('Updated Question Successfully');
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }

    }

    public function destroy($id){
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return $this->successResponse('Question deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }


    // public function BankQuestions($specialization_id)
    // {
    //     $res = Specialization::findOrFail($specialization_id);
    //     $questions = $res->questions()
    //         ->whereNull('term_id')
    //         ->inRandomOrder()
    //         ->limit(50)
    //         ->with('answers')
    //         ->get();
 
    //     return $this->successResponse('Random Bank Questions Depends On Specialization', QuestionResource::collection($questions));
    // }
    

    public function BankQuestions($specialization_id)
{
    try {
        $specialization = Specialization::findOrFail($specialization_id);
        //$specialization = Specialization::where('uuid', $specialization_id)->firstOrFail();

        $questions = $specialization->questions()
            ->whereNull('term_id')
            ->inRandomOrder()
            ->limit(50)
            ->with('answers')
            ->get();

        $questionNumber = 1;
        $answerNumber = 1;
        foreach ($questions as $question) {
            $question['question_number'] = $questionNumber;
            $questionNumber++;
            foreach ($question['answers'] as $answer) {
                $answer['answer_number'] = $answerNumber;
                $answerNumber++;
            }
            $answerNumber=1;
        }

        return $this->successResponse('Random Bank Questions Depends On Specialization', QuestionResource::collection($questions));
    } catch (\Exception $exception) {
        return $this->handleException($exception);
    }
}

    public function QuestionTermForSpecialization($termid){
        $term=Term::findOrFail($termid);
        $res=Term::findOrFail($term->id);
        $questions=$res->questions()->inRandomOrder()
             ->limit(50)->with('answers')->get();

        return $this->successResponse('Random Question Terms',QuestionResource::collection($questions));
    }

    public function getQuestionsBySubject($termId,$subid){
        $term=Term::findOrFail($termId);
        $sub=Subject::findOrFail($subid);

        $questions=$sub->questions()->where('term_id',$term->id)->with('answers')->get();

        return $this->successResponse('Questions For Subject',QuestionResource::collection($questions));
    }

    public function BookQuestion($subid){
        $subject=Subject::findOrFail($subid);
        $subjectres=Subject::findOrFail($subject->id);
        $questions=$subjectres->questions()->with('answers')->whereNull('term_id')->get();

        return $this->successResponse('Book Questions For Subject',QuestionResource::collection($questions));
    }

  public function getQuestionsByid($qid)
{
    $question = Question::findOrFail($qid);

    return $this->successResponse('Question Details', new QuestionResource($question));
}


}
