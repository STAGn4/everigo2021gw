<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\ScopePublished;
use Illuminate\Support\Facades\DB;
use App\Models\BookReviews;
use App\Models\BookGenre;

class Book extends HondanaModelBase
{
    use HasFactory;

    protected $table = 'book';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ScopePublished);
    }

    public function reviews(){
        return $this->hasMany(BookReviews::class,'book_no', 'book_no');
    }

    public function bookGenres(){
        return $this->hasMany(BookGenre::class,'book_no', 'book_no');
    }

    public function getAvgStar()
    {
        return round($this->reviews()->pluck('stars')->avg(), 1);
    }
}

