<?php

namespace App\Models\Recipes;

use App\Models\FilterScope;
use App\Models\SlugifyTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Controllers\Recipes\TagController;

class Recipe extends Model
{
    use FilterScope;
    use SoftDeletes;
    use SoftCascadeTrait;
    use SlugifyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cookbook_id',
        'category_id',
        'name',
        'yield_amount',
        'complexity',
        'instructions',
        'photo',
        'preparation_time',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
    ];

    /**
     * The relations that should cascade on delete
     *
     * @var array
     */
    protected $softCascade = [
        'ingredientDetails',
        'ingredientDetailGroups',
        'ratings',
    ];

    /**
     * Possible values for the complexity_types enum field
     *
     * @var array
     */
    public const COMPLEXITY_TYPES = [
        'simple',
        'normal',
        'difficult',
    ];

    /**
     * Get the full URL to the photo
     *
     * @return string|null
     */
    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return null;
        }

        return \Storage::disk('images')->url("recipes/{$this->photo}");
    }

    /**
     * Get the recipe's author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Users\Author');
    }

    /**
     * Get the recipe's category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Recipes\Category');
    }

    /**
     * Get the recipe's cookbook
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cookbook(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Recipes\Cookbook');
    }

    /**
     * Get the recipe's tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('\App\Models\Recipes\Tag');
    }

    /**
     * Get the recipe's ingredientDetails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetails(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\IngredientDetail');
    }

    /**
     * Get the recipe's ingredientDetailGroups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientDetailGroups(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\IngredientDetailGroup');
    }

    /**
     * Get the recipe's ratings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany('\App\Models\Ratings\Rating');
    }
}
