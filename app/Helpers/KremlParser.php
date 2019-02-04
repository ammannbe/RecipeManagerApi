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
            unset($kremlIngredients);
            unset($kremlDescriptions);
            $kremlIngredients  = $kremlRecipe['krecipes-ingredients'];
            $kremlDescriptions = $kremlRecipe['krecipes-description'];

            if (isset($kremlDescriptions['yield']['amount']) && is_array($kremlDescriptions['yield']['amount'])) {
                $yieldAmount    = (isset($kremlDescriptions['yield']['amount']['min']) ? trim($kremlDescriptions['yield']['amount']['min']) : NULL);
                $yieldAmountMax = (isset($kremlDescriptions['yield']['amount']['max']) ? trim($kremlDescriptions['yield']['amount']['max']) : NULL);
            } else {
                $yieldAmount    = (isset($kremlDescriptions['yield']['amount']) ? trim($kremlDescriptions['yield']['amount']) : NULL);
                $yieldAmountMax = NULL;
            }

            $recipes[] = [
                'author'            => (isset($kremlDescriptions['author']) ? trim($kremlDescriptions['author']) : NULL),
                'preparationTime'   => (isset($kremlDescriptions['preparation-time']) &&
                                    $kremlDescriptions['preparation-time'] != '00:00' ? trim($kremlDescriptions['preparation-time']) : NULL),
                'name'              => (isset($kremlDescriptions['title'])            ? trim($kremlDescriptions['title'])            : NULL),
                'yieldAmount'       => $yieldAmount,
                'yieldAmountMax'    => $yieldAmountMax,
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

            if (!isset($kremlIngredients['ingredient-group'])) {
                if (isset($kremlIngredients['ingredient'])) {
                    $recipes[$key]['ingredientDetails'] = self::ingredientDetails($kremlIngredients['ingredient']);
                }
            } elseif (!isset($kremlIngredients['ingredient'])) {
                if (isset($kremlIngredients['ingredient-group'])) {
                    if (isset($kremlIngredients['ingredient-group']['@name'])) {
                        $groups[] = [
                            '@name'         => $kremlIngredients['ingredient-group']['@name'],
                            'ingredient'    => $kremlIngredients['ingredient-group']['ingredient'],
                        ];
                    } else {
                        $groups = $kremlIngredients['ingredient-group'];
                    }
                    self::ingredientGroups($groups);
                }
            } else {
                if (isset($kremlIngredients['ingredient-group']['@name'])) {
                    $groups[] = [
                        '@name'         => $kremlIngredients['ingredient-group']['@name'],
                        'ingredient'    => $kremlIngredients['ingredient-group']['ingredient'],
                    ];
                } else {
                    $groups = $kremlIngredients['ingredient-group'];
                }

                $merged = array_merge(
                    self::ingredientDetails($kremlIngredients['ingredient']),
                    self::ingredientGroups($groups)
                );
                $recipes[$key]['ingredientDetails'] = $merged;
            }

        }
        return $recipes;
    }

    private static function categories($kremlCategories) {
        if (is_null($kremlCategories)) {
            return [];
        }
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
            if (isset($i['amount']) && is_array($i['amount'])) {
                $amount    = (isset($i['amount']['min']) && $i['amount']['min'] != "0" ? trim($i['amount']['min']) : NULL);
                $amountMax = (isset($i['amount']['max']) && $i['amount']['max'] != "0" ? trim($i['amount']['max']) : NULL);
            } else {
                $amount    = (isset($i['amount']) && $i['amount'] != "0" ? trim($i['amount']) : NULL);
                $amountMax = NULL;
            }

            $ingredientDetails[] = [
                'ingredient'    => (isset($i['name']) ? trim($i['name'])   : NULL),
                'unit'          => (isset($i['unit']) ? trim($i['unit'])   : NULL),
                'amount'        => $amount,
                'amountMax'     => $amountMax,
                'prep'          => (isset($i['prep']) ? trim($i['prep'])   : NULL),
                'position'      => $position++,
                'alternate'     => (isset($i['substitutes']['ingredient']) ? self::ingredientDetails([$i['substitutes']['ingredient']])[0] : NULL),
            ];
        }
        return $ingredientDetails;
    }

    private static function ingredientGroups(Array $kremlIngredientDetailGroups) {
        foreach ($kremlIngredientDetailGroups as $kremlIngredientDetailGroup) {
            $group = (isset($kremlIngredientDetailGroup['@name']) ? trim($kremlIngredientDetailGroup['@name']) : NULL);
            $position = 0;
            foreach ($kremlIngredientDetailGroup['ingredient'] as $i) {
                if (isset($i['amount']) && is_array($i['amount'])) {
                    $amount    = (isset($i['amount']['min']) && $i['amount']['min'] != "0" ? trim($i['amount']['min']) : NULL);
                    $amountMax = (isset($i['amount']['max']) && $i['amount']['max'] != "0" ? trim($i['amount']['max']) : NULL);
                } else {
                    $amount    = (isset($i['amount']) && $i['amount'] != "0" ? trim($i['amount']) : NULL);
                    $amountMax = NULL;
                }

                $ingredientDetails[] = [
                    'group'         => $group,
                    'ingredient'    => (isset($i['name']) ? trim($i['name'])   : NULL),
                    'unit'          => (isset($i['unit']) ? trim($i['unit'])   : NULL),
                    'amount'        => $amount,
                    'amountMax'     => $amountMax,
                    'prep'          => (isset($i['prep']) ? trim($i['prep'])   : NULL),
                    'position'      => $position++,
                    'alternate'     => (isset($i['substitutes']['ingredient']) ? self::ingredientDetails($i['substitutes']['ingredient']) : NULL),
                ];
            }
        }
        return $ingredientDetails;
    }
}
