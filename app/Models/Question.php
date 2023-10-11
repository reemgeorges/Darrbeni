<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Trait\GeneratesUuid;


class Question extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','question_content','reference','subject_id','term_id','specialization_id'];

    public function subject()
{
    return $this->belongsTo(Subject::class);
}

    public function term(): BelongsTo{

        return $this->BelongsTo(Term::class);

    }


    public function specialization(): BelongsTo{

        return $this->BelongsTo(Specialization::class);

    }

    public function answers(): HasMany{

        return $this->hasMany(Answer::class);

    }

    public function users():BelongsToMany{

        return $this->belongsToMany(User::class, 'importances')
            ->withTimestamps();

    }


}
