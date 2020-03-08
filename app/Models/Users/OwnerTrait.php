<?php

namespace App\Models\Users;

use App\Models\Recipes\Recipe;
use App\Models\Recipes\Cookbook;
use App\Models\Ingredients\Ingredient;
use App\Models\Ingredients\IngredientGroup;

trait OwnerTrait
{
    /**
     * Determine if the user is an admin or the owner of a specific object
     *
     * @see User::isOwnerOf()
     * @param  mixed  $object
     * @return bool
     */
    public function isAdminOrOwnerOf($object): bool
    {
        return $this->admin || $this->isOwnerOf($object);
    }

    /**
     * Determine if the user is owner of a specific object
     *
     * @param  mixed  $object
     * @return bool
     */
    public function isOwnerOf($object)
    {
        $class = class_basename($object);
        return $this->{"isOwnerOf{$class}"}($object);
    }

    /**
     * Determine if the user is owner of a specific cookbook
     *
     * @param  \App\Models\Recipes\Cookbook  $cookbook
     * @return bool
     */
    public function isOwnerOfCookbook(Cookbook $cookbook): bool
    {
        return $this->id === $cookbook->user_id;
    }

    /**
     * Determine if the user is owner of a specific recipe
     *
     * @param  \App\Models\Recipes\Recipe  $recipe
     * @return bool
     */
    public function isOwnerOfRecipe(Recipe $recipe): bool
    {
        return $this->id === $recipe->user_id;
    }

    /**
     * Determine if the user is owner of a specific ingredient
     *
     * @param  \App\Models\Ingredients\Ingredient  $ingredient
     * @return bool
     */
    public function isOwnerOfIngredient(Ingredient $ingredient): bool
    {
        return $this->id === $ingredient->recipe->id;
    }

    /**
     * Determine if the user is owner of a specific ingredient-group
     *
     * @param  \App\Models\Ingredients\IngredientGroup  $ingredientGroup
     * @return bool
     */
    public function isOwnerOfIngredientGroup(IngredientGroup $ingredientGroup): bool
    {
        return $this->id === $ingredientGroup->recipe->id;
    }
}
