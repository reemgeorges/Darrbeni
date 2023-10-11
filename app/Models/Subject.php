<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Trait\GeneratesUuid;

class Subject extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','name','Specialization_id','has_master','has_graduation'];

    public function specialization(): BelongsTo{

        return $this->BelongsTo(Specialization::class);

    }

    public function terms(): HasMany {

        return $this->HasMany(Term::class);

    }

    public function questions()
{
    return $this->hasMany(Question::class);
}
}
