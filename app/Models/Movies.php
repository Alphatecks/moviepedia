<?php

namespace App\Models;

use App\Models\MovieGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movies extends Model
{
    use HasFactory;

    public function genre()
    {
        $this->belongsTo(MovieGenre::class);
    }
}
