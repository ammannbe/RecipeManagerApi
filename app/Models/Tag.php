<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Tag extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

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
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'recipes@restrict'
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $name): Builder
    {
        return $query->where('name', 'LIKE', '%' . $name . '%')
            ->with(['recipes', 'recipes.author', 'recipes.category']);
    }

    /**
     * Get the tag's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function recipes()
    {
        return $this->belongsToMany('\App\Models\Recipe');
    }
}
