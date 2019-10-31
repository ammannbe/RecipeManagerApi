<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Unit extends Model
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
        'name_shortcut',
        'name_plural',
        'name_plural_shortcut'
    ];

    /**
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'ingredientDetails@restrict'
    ];

    /**
     * Get the unit's ingredient details
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function ingredientDetail()
    {
        return $this->belongsTo('\App\Models\IngredientDetail');
    }
}
