<?php

namespace App\Models\Recipes;

use App\Models\FilterScope;
use App\Models\SlugifyTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use League\Flysystem\FileNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'photos',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'photos' => 'array'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_urls',
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
                return $q->isOwn();
            })->orWhere(function (Builder $q) {
                return $q->isPublic();
            });
        });
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
     * Get the full URLs of the photos
     *
     * @return array<string>
     */
    public function getPhotoUrlsAttribute(): array
    {
        if (!$this->photos) {
            return [];
        }

        $urls = [];
        foreach ($this->photos as $name) {
            $urls[] = \Storage::disk('recipe_images')->url("{$this->id}/{$name}");
        }

        return $urls;
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
     * Save photos to disk
     *
     * If null given, nothing is done
     *
     * @param  array  $photos  Instances of \Illuminate\Http\UploadedFile
     * @return void
     */
    public function savePhotos(?array $photos): void
    {
        if (!$photos) {
            return;
        }

        if (!\Storage::disk('recipe_images')->exists("{$this->id}")) {
            \Storage::disk('recipe_images')->makeDirectory("{$this->id}");
        }

        $original = $this->photos ?? [];
        foreach ($photos as $key => $photo) {
            if ($photo === null) {
                unset($original[$key]);
                continue;
            }

            if ($photo instanceof UploadedFile) {
                $extension = $photo->getClientOriginalExtension();
                $uuid = \Str::uuid()->toString();
                $name = "{$uuid}-{$this->slug}.{$extension}";

                $photo->storeAs("{$this->id}", $name, 'recipe_images');
                $original[$key] = $name;
                continue;
            }

            throw new FileNotFoundException('Photos have to be uploaded files.');
        }

        $this->update(['photos' => $original ?? null]);
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
