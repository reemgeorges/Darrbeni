<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trait\GeneratesUuid;


class Importance extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','user_id','question_id'];

}
