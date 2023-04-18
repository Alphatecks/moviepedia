<?php

namespace App\Models;

use App\Models\Movies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieGenre extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function movies()
    {
        return $this->hasMany(Movies::class);
    }
}
