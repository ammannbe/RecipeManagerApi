<?php

namespace App\Helpers;
use Parser;

class KremlParser
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
        $recipes = [];
        foreach ($kremlRecipes as $kremlRecipe) {
            unset($kremlIngredients);
            unset($kremlDescriptions);
            $kremlIngredients  = $kremlRecipe['krecipes-ingredients'];
            $kremlDescriptions = $kremlRecipe['krecipes-description'];
            $recipeArray = [
                'recipe'   => [
                    'user_id'          => NULL,
                    'cookbook_id'      => NULL,
                    'category_id'      => NULL,
                    'author_id'        => NULL,
                    'name'             => NULL,
                    'yield_amount'     => NULL,
                    'instructions'     => NULL,
                    'photo'            => NULL,
                    'preparation_time' => NULL,
                ],
                'author'   => [ 'name' => NULL ],
                'category' => [ 'name' => NULL ],
                'photo'    => [
                    'base64'    => NULL,
                    'extension' => NULL,
                    'name'      => NULL,
                    'path'      => NULL,
                ],
                'ingredient_details' => NULL,
            ];

            if (isset($kremlDescriptions['yield']['amount'])) {
                if (is_array($kremlDescriptions['yield']['amount'])) {
                    $recipeArray['recipe']['yield_amount'] = trim($kremlDescriptions['yield']['amount']['min']);
                } else {
                    $recipeArray['recipe']['yield_amount'] = trim($kremlDescriptions['yield']['amount']);
                }
            }

            if (is_array($kremlDescriptions['category']['cat'])) {
                $recipeArray['category']['name'] = trim($kremlDescriptions['category']['cat'][0]);
            } else {
                $recipeArray['category']['name'] = trim($kremlDescriptions['category']['cat']);
            }

            if (isset($kremlDescriptions['author'])) {
                $recipeArray['author']['name'] = trim($kremlDescriptions['author']);
            }

            if (isset($kremlDescriptions['preparation-time'])) {
                if ($kremlDescriptions['preparation-time'] !== '00:00') {
                    $recipeArray['recipe']['preparation_time'] = trim($kremlDescriptions['preparation-time']);
                }
            }

            if (isset($kremlDescriptions['title'])) {
                $recipeArray['recipe']['name'] = trim($kremlDescriptions['title']);
            }

            if (isset($kremlRecipe['krecipes-instructions'])) {
                $recipeArray['recipe']['instructions'] = trim($kremlRecipe['krecipes-instructions']);
            }

            if (isset($kremlDescriptions['pictures']['pic'])) {
                if ($kremlPicture = $kremlDescriptions['pictures']['pic']) {
                    if (isset($kremlPicture['#text'])) {
                        $recipeArray['photo']['base64'] = $kremlPicture['#text'];
                    }
                    if (isset($kremlPicture['@format'])) {
                        $recipeArray['photo']['extension'] = strtolower(trim($kremlPicture['@format']));
                    }
                }
            }


            // Reset $groups
            $groups = [];

            // If NO group
            if (isset($kremlIngredients['ingredient'])) {
                $groups[] = [
                    '@name'      => NULL,
                    'ingredient' => $kremlIngredients['ingredient'],
                ];
            }

            // If ONE group
            if (isset($kremlIngredients['ingredient-group']['@name'])) {
                $groups[] = [
                    '@name'      => $kremlIngredients['ingredient-group']['@name'],
                    'ingredient' => $kremlIngredients['ingredient-group']['ingredient'],
                ];

            // If MULTIPLE groups
            } else {
                if (isset($kremlIngredients['ingredient-group'])) {
                    if (!isset($kremlIngredients['ingredient-group']['@name'])) {
                        $groups = array_merge($groups, $kremlIngredients['ingredient-group']);
                    }
                }
            }

            // Go through groups/ingredients
            foreach ($groups as $group) {
                if ($group['ingredient']) {
                    $position = 0;
                    foreach ($group['ingredient'] as $ingredient) {
                        // Default structure
                        $detail = [
                            'group'      => NULL,
                            'name'       => NULL,
                            'amount'     => NULL,
                            'amount_max' => NULL,
                            'unit'       => NULL,
                            'preps'      => NULL,
                            'position'   => NULL,
                            'alternate'  => NULL,
                        ];

                        $detailSubstitute = $detail;

                        if (isset($group['@name'])) {
                            $detail['group'] = trim($group['@name']);
                        }
                        if (isset($ingredient['name'])) {
                            $detail['ingredient'] = trim($ingredient['name']);
                        }
                        if (isset($ingredient['amount'])) {
                            if (is_array($ingredient['amount'])) {
                                $detail['amount'] = trim($ingredient['amount']['min']);
                                $detail['amount_max'] = trim($ingredient['amount']['max']);
                            } else {
                                $detail['amount'] = trim($ingredient['amount']);
                            }
                        }
                        if (isset($ingredient['unit'])) {
                            $detail['unit'] = trim($ingredient['unit']);
                        }
                        if (isset($ingredient['prep'])) {
                            $detail['preps'] = self::getPreps($ingredient['prep']);
                        }

                        $detail['position'] = $position++;

                        // Set alternatives
                        if (isset($ingredient['substitutes'])) {
                            $substitutes = NULL;
                            if (isset($ingredient['substitutes']['ingredient'][0])) {
                                foreach ($ingredient['substitutes']['ingredient'] as $ingredient) {
                                    $detail['alternate'][] = array_merge($detailSubstitute, $ingredient);
                                }
                            } else {
                                $substitutes = $ingredient['substitutes']['ingredient'];
                                $substitutes['group'] = $detail['group'];

                                $detail['alternate'][] = array_replace($detailSubstitute, $substitutes);
                            }
                        }

                        $recipeArray['ingredient_details'][] = $detail;
                    }
                }
                $group = NULL;
            }
            $recipes[] = $recipeArray;
        }
        return $recipes;
    }

    private static function getPreps(String $prep = NULL) {
        if ($prep) {
            return explode(',', $prep);
        } else {
            return NULL;
        }
    }
}
