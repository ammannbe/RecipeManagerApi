<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

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
     * Search recipes by category name
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchRecipes($name) {
        return self::where('name', 'LIKE', '%'.$name.'%')
            ->with(['recipes', 'recipes.author', 'recipes.category'])
            ->get();
    }

    /**
     * Get the category's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes() {
        return $this->hasMany('\App\Models\Recipe');
    }
}
