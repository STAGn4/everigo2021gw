<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\ScopePublished;
use App\Models\BookGenre;
use Illuminate\Support\Facades\DB;

class Genre extends HondanaModelBase
{
    use HasFactory;

    protected $table = 'genre';

    public function bookGenres(){
        return $this->hasMany(BookGenre::class,'genre_no', 'genre_no');
    }
}
