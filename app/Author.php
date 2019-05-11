<?php

namespace App;

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

    public function searchRecipes($name) {
        return $this->where('name', 'LIKE', '%'.$name.'%')
            ->with(['recipes', 'recipes.author', 'recipes.category'])
            ->get();
    }

    public function recipes() {
        return $this->hasMany('\App\Recipe');
    }
}
