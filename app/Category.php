<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'category_id'];

    public function search($name) {
        return $this->where('name', 'LIKE', '%'.$name.'%')->get();
    }

    public function recipes() {
        return $this->belongsToMany('\App\Recipe');
    }
}