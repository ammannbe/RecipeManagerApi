<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'name_shortcut',
        'name_plural',
        'name_plural_shortcut'
    ];
}
