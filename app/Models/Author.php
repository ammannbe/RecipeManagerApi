<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRouteKeyName() {
        return 'slug';
    }

    public static function searchRecipes($name) {
        return self::where('name', 'LIKE', '%'.$name.'%')
            ->with(['recipes', 'recipes.author', 'recipes.category'])
            ->get();
    }

    public function recipes() {
        return $this->hasMany('\App\Models\Recipe');
    }
}
