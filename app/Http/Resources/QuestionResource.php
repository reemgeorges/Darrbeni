<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $correctAnswer = $this->answers()->where('is_correct', true)->first();
        $isImportant = false;
        if (Auth::check()) {
            $user = Auth::user();
            $importance = $user->importances()->where('question_id', $this->id)->first();
            if ($importance) {
                $isImportant = true;
            }
        }
        // return [
        //     'id' => $this->id,
        //     'uuid' => $this->uuid,
        //     'question_content' => $this->question_content,
        //     'reference' => $this->reference,
        //     'subject_id' => $this->subject_id,
        //     'specialization_id' => $this->specialization_id,
        //     'correct_id' => $correctAnswer ? $correctAnswer->id : null,
        //     'IsImportant' => $isImportant,
        //     'answers' => AnswerResource::collection($this->answers),
        // ];

        return [
            'id'=>$this->id,
            'question_number'=>$this->question_number,
            'uuid'=>$this->uuid,
            'question_content'=>$this->question_content,
            'reference'=>$this->reference,
            'subject_id'=>$this->subject_id,
            'term_id'=>$this->term_id,
            'correct_id' => $correctAnswer ? $correctAnswer->id : null,
            'IsImportant' => $isImportant,
            'answers'=>AnswerResource::collection($this->answers)
        ];

        
    }
}
