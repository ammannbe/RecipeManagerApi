<?php

namespace App\Models\Recipes;

use App\Models\FilterScope;
use App\Models\SlugifyTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Recipes\Recipe
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $cookbook_id
 * @property int $category_id
 * @property int $author_id
 * @property string $name
 * @property string $slug
 * @property string|null $yield_amount
 * @property string $complexity
 * @property string $instructions
 * @property string|null $preparation_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Users\Author $author
 * @property-read \App\Models\Recipes\Category $category
 * @property-read \App\Models\Recipes\Cookbook|null $cookbook
 * @property-read bool $can_edit
 * @property-read string $complexity_text
 * @property-read Collection $photos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredients\IngredientGroup[] $ingredientGroups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredients\Ingredient[] $ingredients
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ratings\Rating[] $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recipes\Tag[] $tags
 * @method static Builder|Recipe filter(?array $filter, ?string $method = 'and')
 * @method static Builder|Recipe isOwn()
 * @method static Builder|Recipe isPublic()
 * @method static Builder|Recipe newModelQuery()
 * @method static Builder|Recipe newQuery()
 * @method static \Illuminate\Database\Query\Builder|Recipe onlyTrashed()
 * @method static Builder|Recipe query()
 * @method static Builder|Recipe whereAuthorId($value)
 * @method static Builder|Recipe whereCategoryId($value)
 * @method static Builder|Recipe whereComplexity($value)
 * @method static Builder|Recipe whereCookbookId($value)
 * @method static Builder|Recipe whereCreatedAt($value)
 * @method static Builder|Recipe whereDeletedAt($value)
 * @method static Builder|Recipe whereId($value)
 * @method static Builder|Recipe whereInstructions($value)
 * @method static Builder|Recipe whereName($value)
 * @method static Builder|Recipe wherePreparationTime($value)
 * @method static Builder|Recipe whereSlug($value)
 * @method static Builder|Recipe whereUpdatedAt($value)
 * @method static Builder|Recipe whereUserId($value)
 * @method static Builder|Recipe whereYieldAmount($value)
 * @method static \Illuminate\Database\Query\Builder|Recipe withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Recipe withoutTrashed()
 * @mixin \Eloquent
 */
class Recipe extends Model implements HasMedia
{
    use FilterScope, SoftDeletes, SoftCascadeTrait, SlugifyTrait, HasFactory, InteractsWithMedia;

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
        'preparation_time',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photos',
        'can_edit',
    ];

    /**
     * The relations that should cascade on delete
     *
     * @var array
     */
    protected $softCascade = [
        'ingredients',
        'ingredientGroups',
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isAdminOrOwnOrPublic', function (Builder $query) {
            if (auth()->check() && auth()->user()->admin) {
                return $query;
            }

            return $query->where(function (Builder $q) {
                /** @var Recipe $q */
                return $q->isOwn();
            })->orWhere(function (Builder $q) {
                /** @var Recipe $q */
                return $q->isPublic();
            });
        });
    }

    /**
     * Register new media conversions
     *
     * This method is used by the  spatie/laravel-medialibrary package
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('webp')
            ->format(Manipulations::FORMAT_WEBP);
    }

    /**
     * Get only the recipes of the logged in user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsOwn(Builder $builder): Builder
    {
        return $builder->whereUserId(auth()->id());
    }

    /**
     * Get only the "public" recipes
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPublic(Builder $builder): Builder
    {
        return $builder->whereNull('cookbook_id');
    }

    /**
     * Get translated text of complexities
     *
     * @return string
     */
    public function getComplexityTextAttribute(): string
    {
        $text = '';

        switch ($this->attributes['complexity']) {
            case 'simple':
                $text = __('Simple');
                break;

            case 'normal':
                $text = __('Normal');
                break;

            case 'difficult':
                $text = __('Difficult');
                break;
        }

        /** @var string */
        return $text;
    }

    /**
     * Get the preparation time
     *
     * Return NULL, if the time is 00:00:00
     *
     * @return string|null
     */
    public function getPreparationTimeAttribute(): ?string
    {
        if ($this->attributes['preparation_time'] == '00:00:00') {
            return null;
        }

        return $this->attributes['preparation_time'];
    }

    /**
     * Get the related photos
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPhotosAttribute(): Collection
    {
        return $this->getMedia('recipe_photos')->map(function (Media $media) {
            return collect([
                'id'    => $media->id,
                'name'  => $media->name,
                'url'   => $media->getUrl(),
            ]);
        });
    }

    /**
     * Evaluate if the user can edit this recipe
     *
     * @return bool
     */
    public function getCanEditAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return auth()->user()->can('update', $this);
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
     * Get the recipe's ingredients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\Ingredient');
    }

    /**
     * Get the recipe's ingredientGroups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientGroups(): HasMany
    {
        return $this->hasMany('\App\Models\Ingredients\IngredientGroup');
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
