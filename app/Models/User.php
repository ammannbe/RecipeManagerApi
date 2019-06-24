<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftCascadeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Check if the user is an admin
     *
     * @return Bool
     */
    public function isAdmin() {
        return ($this->user_type == 'admin');
    }

    /**
     * Get the user's recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function recipes() {
        return $this->hasMany('\App\Models\Recipe');
    }
}
