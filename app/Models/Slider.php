<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trait\GeneratesUuid;

class Slider extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','image_url','link'];
}
