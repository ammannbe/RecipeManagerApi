<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cookbook extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function search($name) {
        return $this->where('name', 'LIKE', '%'.$name.'%')->get();
    }

    public function recipes() {
        return $this->hasMany('\App\Recipe');
    }
}
