<?php

namespace App\Models;

use App\Models\MovieGenre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movies extends Model
{
    use HasFactory,softDeletes;

    protected $guarded = [];

    public function movie_genre()
    {
      return  $this->belongsTo(MovieGenre::class,'genre_id');
    }
}
