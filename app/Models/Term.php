<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Trait\GeneratesUuid;

class Term extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','term_name','specialization_id'];


    public function specialization(): BelongsTo{

        return $this->belongsTo(Specialization::class);

    }

    public function questions(): HasMany {

        return $this->HasMany(Question::class);

    }

    public function scopeOfType($query, $type){

        return $query->where('type', $type);
    }
}
