<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     'text' => $this->answer_content,
        //     'id' => $this->id,
        // ];

        return [
            'id'=>$this->id,
            'answer_number' => $this->answer_number,
            'uuid'=>$this->uuid,
            'answer_content'=>$this->answer_content,
            'question_id'=>$this->question_id,
            'is_correct'=>$this->is_correct
        ];
    }
}
