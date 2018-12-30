<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name'];

    public function search($name) {
        return $this->where('name', 'LIKE', '%'.$name.'%')->get();
    }

    public function recipes() {
        return $this->hasMany('\App\Recipe');
    }
}
