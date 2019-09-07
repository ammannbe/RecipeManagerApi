<?php

namespace App\Models;

use App\Models\Recipe;
use App\Helpers\RecipeHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class IngredientDetail extends Model
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
        'amount',
        'unit_id',
        'ingredient_id',
        'ingredient_detail_group_id',
        'position',
        'ingredient_detail_id'
    ];

    /**
     * Beatufy the ingredient detail list
     *
     * e.g. 100 g Mandeln, gehackt
     *
     * @return string
     */
    public function beautify()
    {
        $text = '';
        if ($this->amount)     $text = $text.$this->amount;
        if ($this->amount &&
            $this->amount_max) $text = $text.'-';
        if ($this->amount_max) $text = $text.$this->amount_max;
        if ($this->unit)       $text = $text.' '.RecipeHelper::getSuitableUnit($this->unit, $this->amount);;
        if ($this->ingredient) $text = $text.' '.$this->ingredient->name;
        foreach ($this->preps as $prep) {
            $text = $text.', '.$prep->name;
        }
        return $text;
    }

    /**
     * Reorder the ingredient-details' position from a recipe
     *
     * @param \App\Models\Recipe $recipe
     */
    public static function reorder(Recipe $recipe)
    {
        $ingredientDetails = IngredientDetail::where('recipe_id', $recipe->id)
            ->orderBy('ingredient_detail_group_id')
            ->orderBy('position')
            ->get();
        $lastIngredientDetail = null;
        $i = 1;
        $j = 1;

        foreach ($ingredientDetails as $ingredientDetail) {
            if ($ingredientDetail->ingredient_detail_id) {
                $ingredientDetail->position = 1;
            } elseif ($ingredientDetail->ingredient_detail_group_id) {
                if ($ingredientDetail != $lastIngredientDetail) {
                    $j = 1;
                }
                $ingredientDetail->position = $j;
                $j++;
            } else {
                $ingredientDetail->position = $i;
                $i++;
            }
            $ingredientDetail->save();

            $lastIngredientDetail = $ingredientDetail;
        }
    }

    /**
     * Get the ingredient-detail's alternate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetail()
    {
        return $this->hasMany('\App\Models\IngredientDetail');
    }

    /**
     * Get the ingredient-detail's recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('\App\Models\Recipe');
    }

    /**
     * Get the ingredient-detail's unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo('\App\Models\Unit');
    }

    /**
     * Get the ingredient-detail's ingredient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient()
    {
        return $this->belongsTo('\App\Models\Ingredient');
    }

    /**
     * Get the ingredient-detail's preps
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function preps()
    {
        return $this->belongsToMany('\App\Models\Prep');
    }

    /**
     * Get the ingredient-detail's group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('\App\Models\IngredientDetailGroup', 'ingredient_detail_group_id');
    }
}
