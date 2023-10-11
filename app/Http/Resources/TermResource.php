<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'questionText' => $this->question_content,
            'reference'=>$this->reference,
            'answers' => AnswerResource::collection($this->answers),
            'correct_id' => $this->answers()->where('is_correct', true)->first()->id,
        ];
    }
}
