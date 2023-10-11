<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Trait\GeneratesUuid;

class Collage extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','collage_name'];

    public function specializations(): HasMany{

        return $this->HasMany(Specialization::class);

    }


}
