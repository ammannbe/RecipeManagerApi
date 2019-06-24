<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class IngredientDetailGroup extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'name'
    ];

    /**
     * Get the ingredient-detail-group's recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe() {
        return $this->belongsTo('\App\Models\Recipe');
    }

    /**
     * Get the ingredient-detail-group's ingredient-details
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function ingredientDetails() {
        return $this->hasMany('\App\Models\IngredientDetail');
    }
}
