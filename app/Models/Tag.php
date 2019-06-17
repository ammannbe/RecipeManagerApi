<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Search recipes by tag name
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchRecipes($name) {
        return self::where('name', 'LIKE', '%'.$name.'%')
            ->with(['recipes', 'recipes.author', 'recipes.category'])
            ->get();
    }

    /**
     * Get the tag's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function recipes() {
        return $this->belongsToMany('\App\Models\Recipe');
    }
}
