<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\ScopePublished;
// use Illuminate\Support\Facades\DB;

class Company extends HondanaModelBase
{
    use HasFactory;

    protected $table = 'company';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ScopePublished);
    }
}
