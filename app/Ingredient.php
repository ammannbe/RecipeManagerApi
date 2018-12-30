<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name'];

    public function search($name) {
        $ingredients = $this->where('name', 'LIKE', '%'.$name.'%')->get();
        foreach ($ingredients as $ingredient) {
            $ingredientDetails = \App\IngredientDetail::where('ingredient_id', '=', $ingredient->id)->get();
            foreach ($ingredientDetails as $ingredientDetail) {
                $result[$ingredientDetail->id] = $ingredientDetail;
            }
        }
        return (isset($result) ? $result : []);
    }

    public function recipes() {
        return $this->belongsToMany('\App\Recipe');
    }
}
