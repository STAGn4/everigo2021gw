<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class BookGenre extends HondanaModelBase
{
    use HasFactory;

    protected $table = 'book_genre';

    public function genre(){
        return $this->belongTo(Genre::class,'genre_no', 'genre_no');
    }
}
