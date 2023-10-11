<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    use JsonResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'question_content'=>'required|string',
            'reference'=>'required|string',
            'subject_id'=>'required|integer|exists:subjects,id',
            'term_id'=>'nullable|integer|exists:terms,id'
        ];
    }
}
