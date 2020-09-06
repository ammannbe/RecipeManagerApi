<?php

namespace App\Models\Users;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property  int  $id
 * @property  \App\Models\Users\Author  $author
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes, SoftCascadeTrait, OwnerTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email_verified_at',
        'password',
        'remember_token',
        'author',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
        'has_verified_email',
    ];

    /**
     * Relations that cascade or restrict on delete.
     *
     * @var array
     */
    protected $softCascade = [
        'recipes'
    ];

    /**
     * Get the name attribute
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->author->name ?? '';
    }

    /**
     * Check if the user has a verified email
     *
     * @return bool
     */
    public function getHasVerifiedEmailAttribute(): bool
    {
        return $this->hasVerifiedEmail();
    }

    /**
     * Get the user's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes(): HasMany
    {
        return $this->hasMany('\App\Models\Recipes\Recipe');
    }

    /**
     * Get the user's cookbooks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cookbooks(): HasMany
    {
        return $this->hasMany('\App\Models\Recipes\Cookbook');
    }

    /**
     * Get the user's author
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne('\App\Models\Users\Author');
    }
}
