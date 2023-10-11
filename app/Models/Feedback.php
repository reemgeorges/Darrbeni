<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Trait\GeneratesUuid;

class Feedback extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','user_id','feedback_content'];

    public function user():BelongsTo {

        return $this->BelongsTo(User::class);

    }
}
