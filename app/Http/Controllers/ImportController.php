<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportFormRequest;
use App\Helpers\KremlParser;
use App\Helpers\FormatHelper;
use App\Helpers\FormHelper;
use App\Author;
use App\Category;
use App\Recipe;
use App\Ingredient;
use App\IngredientDetail;
use App\IngredientDetailGroup;
use App\Unit;
use App\Prep;
use Auth;

class ImportController extends Controller
{
    public function index(ImportFormRequest $request) {
        $file = [
            'content'   => file_get_contents($request->file),
            'extension' => $request->file->getClientOriginalExtension(),
        ];

        $call = $file['extension'];
        if (method_exists($this, $call)) {
            return $this->$call($file['content']);
        } else {
            return redirect('/recipes/import')
                ->withErrors(['Dieses Format wird nicht unterstützt.'])
                ->withInput();
        }
    }

    public function form() {
        return view('recipes.import');
    }

    private function kreml(String $kreml) {
        $parsedRecipes = KremlParser::parse($kreml);

        foreach ($parsedRecipes as $pRecipe) {
            $author = $category = NULL;

            if ($pRecipe['author']['name']) {
                $author = Author::firstOrCreate(['name' => $pRecipe['author']['name']]);
            }

            $category = Category::firstOrCreate(['name' => $pRecipe['category']['name']]);

            if ($pRecipe['photo']['extension']) {
                $pRecipe['recipe']['photo'] = FormatHelper::generatePhotoName($pRecipe['recipe']['name'], $pRecipe['photo']['extension']);
                $pRecipe['photo']['path'] = public_path().'/images/recipes/'.$pRecipe['recipe']['photo'];
                file_put_contents($pRecipe['photo']['path'], base64_decode($pRecipe['photo']['base64']));
            }

            $recipe = Recipe::create(
                    array_merge($pRecipe['recipe'], [
                        'author_id'         => ($author ? $author->id : NULL),
                        'category_id'       => $category->id,
                        'user_id'           => auth()->user()->id,
                        'slug'              => FormatHelper::slugify($pRecipe['recipe']['name']),
                    ]
                ));

            if ($pRecipe['ingredient_details']) {
                foreach ($pRecipe['ingredient_details'] as $ingredientDetail) {
                    $this->addIngredientDetail($recipe, $ingredientDetail);
                }
            }
        }

        \Toast::info('Rezepte wurden importiert.');
        return redirect('/admin');
    }

    private function addIngredientDetail(Recipe $recipe, Array $ingredientDetail, IngredientDetail $alternateTo = NULL) {
        if (!isset($ingredientDetail['ingredient']) || ! $ingredientDetail['ingredient']) {
            return;
        }
        $ingredient = $unit = $preps = $group = NULL;

        $ingredientDetail['recipe_id'] = $recipe->id;
        if ($alternateTo) {
            $ingredientDetail['ingredient_detail_id'] = $alternateTo->id;
        }
        if ($ingredientDetail['ingredient']) {
            $ingredientDetail['ingredient_id'] = Ingredient::firstOrCreate(['name' => $ingredientDetail['ingredient']])->id;
        }
        if ($ingredientDetail['unit']) {
            $ingredientDetail['unit_id'] = Unit::firstOrCreate(['name' => $ingredientDetail['unit']])->id;
        }
        if ($ingredientDetail['preps']) {
            foreach ($ingredientDetail['preps'] as $prep) {
                $preps[] = Prep::firstOrCreate(['name' => $prep])->id;
            }
        }
        if ($ingredientDetail['group']) {
            $ingredientDetail['ingredient_detail_group_id'] = IngredientDetailGroup::firstOrCreate([
                    'name'      => $ingredientDetail['group'],
                    'recipe_id' => $recipe->id,
                ])->id;
        }

        $ingredientDetail = IngredientDetail::create($ingredientDetail);

        if ($preps) {
            $ingredientDetail->preps()->sync($preps);
        }

        if ($ingredientDetail['alternate']) {
            foreach ($ingredientDetail['alternate'] as $alternate) {
                $this->addIngredientDetail($recipe, $ingredientDetail['alternate'], $ingredientDetail);
            }
        }
    }
}
