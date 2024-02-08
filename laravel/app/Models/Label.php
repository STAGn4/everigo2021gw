<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\ScopePublished;
// use Illuminate\Support\Facades\DB;

class Label extends HondanaModelBase
{
    use HasFactory;

    protected $table = 'label';
}
