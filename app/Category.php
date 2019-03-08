<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function searchRecipes($name) {
        return $this->where('name', 'LIKE', '%'.$name.'%')
            ->with(['recipes', 'recipes.author', 'recipes.category'])
            ->get();
    }

    public function recipes() {
        return $this->hasMany('\App\Recipe');
    }
}
