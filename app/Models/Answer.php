<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Trait\GeneratesUuid;

class Answer extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','answer_content','question_id','is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
