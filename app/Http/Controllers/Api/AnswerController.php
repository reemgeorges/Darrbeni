<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use Exception;

class AnswerController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        try {
            $answer=Answer::create([
                'answer_content'=>$request->answer_content,
                'question_id'=>$request->question_id,
                'is_correct'=>$request->is_correct,
            ]);
            return $this->successResponse('Answer added Successfully');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request, $id)
    {
        try {
            $answer = Answer::findOrFail($id);

            $answer->answer_content = $request->answer_content;
            $answer->question_id = $request->question_id;
            $answer->is_correct = $request->is_correct;
            $answer->save();

            return $this->successResponse('Updated answer Successfully');
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $answer = Answer::findOrFail($id);
            $answer->delete();

            return $this->successResponse('Answer deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

    }
}
