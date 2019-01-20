<?php

namespace App\Helpers;
use Parser;

use Illuminate\Database\Eloquent\Model;

class KremlParser extends Model
{

    public static function parse(String $kreml) {
        $kremlArray = Parser::xml($kreml);
        if (isset($kremlArray['krecipes-recipe']['@id'])) {
            $kremlRecipes = [$kremlArray['krecipes-recipe']];
        } else {
            $kremlRecipes = $kremlArray['krecipes-recipe'];
        }
        return self::recipes($kremlRecipes);
    }

    private static function recipes(Array $kremlRecipes) {
        foreach ($kremlRecipes as $kremlRecipe) {
            $kremlDescriptions = $kremlRecipe['krecipes-description'];

            $recipes[] = [
                'author'            => (isset($kremlDescriptions['author']) ? trim($kremlDescriptions['author']) : NULL),
                'preparationTime'   => (isset($kremlDescriptions['preparation-time']) &&
                                    $kremlDescriptions['preparation-time'] != '00:00' ? trim($kremlDescriptions['preparation-time']) : NULL),
                'name'              => (isset($kremlDescriptions['title'])            ? trim($kremlDescriptions['title'])            : NULL),
                'yieldAmount'       => (isset($kremlDescriptions['yield']['amount'])  ? trim($kremlDescriptions['yield']['amount'])  : NULL),
                'instructions'      => (isset($kremlRecipe['krecipes-instructions'])  ? trim($kremlRecipe['krecipes-instructions'])  : NULL),
                'categories'        => self::categories($kremlDescriptions['category']['cat']),
            ];

            end($recipes);
            $key = key($recipes);
            reset($recipes);

            if (isset($kremlDescriptions['pictures']['pic']) && !is_null($kremlDescriptions['pictures']['pic'])) {
                $kremlPicture = $kremlDescriptions['pictures']['pic'];
                $recipes[$key]['photo'] = [
                    'base64'    => (isset($kremlPicture['#text'])   ? $kremlPicture['#text']                     : NULL),
                    'extension' => (isset($kremlPicture['@format']) ? strtolower(trim($kremlPicture['@format'])) : NULL),
                ];
            }

            if (!isset($kremlRecipe['krecipes-ingredients']['ingredient-group'])) {
                if (isset($kremlRecipe['krecipes-ingredients']['ingredient'])) {
                    $recipes[$key]['ingredientDetails'] = self::ingredientDetails($kremlRecipe['krecipes-ingredients']['ingredient']);
                }
            } else {
                if (isset($kremlRecipe['krecipes-ingredients']['ingredient-group']['@name'])) {
                    $groups[] = [
                        '@name'         => $kremlRecipe['krecipes-ingredients']['ingredient-group']['@name'],
                        'ingredient'    => $kremlRecipe['krecipes-ingredients']['ingredient-group']['ingredient'],
                    ];
                } else {
                    $groups = $kremlRecipe['krecipes-ingredients']['ingredient-group'];
                }
                $merged = array_merge(
                    self::ingredientDetails($kremlRecipe['krecipes-ingredients']['ingredient']),
                    self::ingredientGroups($groups)
                );
                $recipes[$key]['ingredientDetails'] = $merged;
            }

        }
        return $recipes;
    }

    private static function categories($kremlCategories) {
        if (is_string($kremlCategories)) {
            $kremlCategories = explode(',', $kremlCategories);
        }
        foreach ($kremlCategories as $kremlCategory) {
            $categories[] = trim($kremlCategory);
        }
        return $categories;
    }

    private static function ingredientDetails(Array $kremlIngredientDetails) {
        $position = 0;
        foreach ($kremlIngredientDetails as $i) {
            $ingredientDetails[] = [
                'ingredient'    => (isset($i['name'])   ? trim($i['name'])   : NULL),
                'unit'          => (isset($i['unit'])   ? trim($i['unit'])   : NULL),
                'amount'        => (isset($i['amount']) && $i['amount'] != "0" ? trim($i['amount']) : NULL),
                'prep'          => (isset($i['prep'])   ? trim($i['prep'])   : NULL),
                'position'      => $position++,
                'alternate'     => (isset($i['substitutes']['ingredient']) ? self::ingredientDetails($i['substitutes']['ingredient']) : NULL),
            ];
        }
        return $ingredientDetails;
    }

    private static function ingredientGroups(Array $kremlIngredientDetailGroups) {
        foreach ($kremlIngredientDetailGroups as $kremlIngredientDetailGroup) {
            $group = (isset($kremlIngredientDetailGroup['@name']) ? trim($kremlIngredientDetailGroup['@name']) : NULL);
            $position = 0;
            foreach ($kremlIngredientDetailGroup['ingredient'] as $i) {
                $ingredientDetails[] = [
                    'group'         => $group,
                    'ingredient'    => (isset($i['name'])   ? trim($i['name'])   : NULL),
                    'unit'          => (isset($i['unit'])   ? trim($i['unit'])   : NULL),
                    'amount'        => (isset($i['amount']) && $i['amount'] != "0" ? trim($i['amount']) : NULL),
                    'prep'          => (isset($i['prep'])   ? trim($i['prep'])   : NULL),
                    'position'      => $position++,
                    'alternate'     => (isset($i['substitutes']['ingredient']) ? self::ingredientDetails($i['substitutes']['ingredient']) : NULL),
                ];
            }
        }
        return $ingredientDetails;
    }
}
