<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportFormRequest;
use App\Helpers\KremlParser;
use App\Helpers\FormatHelper;
use App\Cookbook;
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
        $input = $request->all();

        if (isset($input['cookbook']) && $input['cookbook']) {
            if (! $cookbook = Cookbook::where('name', $input['cookbook'])->first()) {
                $cookbook = Cookbook::create(['name' => $input['cookbook'], 'user_id' => $user->id]);
            }
        }

        $file = [
            'content'   => file_get_contents($input['file']),
            'extension' => $input['file']->getClientOriginalExtension(),
        ];

        $call = $file['extension'];
        if (method_exists($this, $call)) {
            return $this->$call($file['content'], $cookbook);
        } else {
            \Toast::error('Dieses Format wird nicht unterstützt.');
            return redirect('/recipes/import');
        }
    }

    public function form() {
        foreach (Cookbook::orderBy('name')->get() as $cookbook) {
            $cookbooks[$cookbook->id] = $cookbook->name;
        }

        return view('recipes.import', compact('cookbooks'));
    }

    private function kreml(String $kreml, Cookbook $cookbook) {
        $parsedRecipes = KremlParser::parse($kreml);

        foreach ($parsedRecipes as $parsedRecipe) {
            if (isset($parsedRecipe['author'])) {
                if (!$author = Author::where('name', $parsedRecipe['author'])->first()) {
                    $author = Author::create(['name' => $parsedRecipe['author']]);
                }
            }

            if (isset($parsedRecipe['photo'])) {
                $parsedRecipe['photo']['name'] = time().'-'.FormatHelper::slugify($parsedRecipe['name']).'.'.$parsedRecipe['photo']['extension'];
                $parsedRecipe['photo']['path'] = public_path().'/images/recipes/'.$parsedRecipe['photo']['name'];

                if (! file_put_contents($parsedRecipe['photo']['path'], base64_decode($parsedRecipe['photo']['base64']))) {
                    \Toast::error('Fehler beim Hochladen des Bildes für Rezept "' . $parsedRecipe['name'] . '"');
                }
            } else {
                $parsedRecipe['photo']['name'] = NULL;
            }

            $recipe = Recipe::create([
                'author_id'         => (isset($author->id) ? $author->id : NULL),
                'cookbook_id'       => $cookbook->id,
                'user_id'           => Auth::user()->id,
                'name'              => $parsedRecipe['name'],
                'yield_amount'      => $parsedRecipe['yieldAmount'],
                'yield_amount_max'  => $parsedRecipe['yieldAmountMax'],
                'instructions'      => $parsedRecipe['instructions'],
                'photo'             => $parsedRecipe['photo']['name'],
                'preparation_time'  => $parsedRecipe['preparationTime'],
            ]);

            if (isset($parsedRecipe['ingredientDetails'])) {
                foreach ($parsedRecipe['ingredientDetails'] as $parsedIngredientDetail) {
                    $this->mapIngredientDetail($recipe, $parsedIngredientDetail);
                }
            }

            foreach ($parsedRecipe['categories'] as $categoryName) {
                if (! $category = Category::where(['name' => $categoryName])->get()->first()) {
                    $category = Category::create(['name' => $categoryName]);
                }
                $recipe->categories()->sync($category->id);
            }
        }

        \Toast::info('Rezept(e) wurden importiert.');
        return redirect('/');
    }

    private function mapIngredientDetail(Recipe $recipe, Array $ingredientDetailToMap) {
        if (!isset($ingredientDetailToMap['ingredient']) || is_null($ingredientDetailToMap['ingredient'])) {
            return NULL;
        }

        foreach (['ingredient', 'unit', 'prep'] as $name) {
            if (isset($ingredientDetailToMap[$name]) && !is_null($ingredientDetailToMap[$name])) {
                $cname = '\\App\\'.ucfirst($name);
                if (! $obj[$name] = $cname::where('name', $ingredientDetailToMap[$name])->first()) {
                    $obj[$name] = $cname::create(['name' => $ingredientDetailToMap[$name]]);
                }
            }
        }

        if (isset($ingredientDetailToMap['group'])) {
            $groupArray = [
                'name'      => $ingredientDetailToMap['group'],
                'recipe_id' => $recipe->id,
            ];

            if (! $group = IngredientDetailGroup::where($groupArray)->first()) {
                $group = IngredientDetailGroup::create($groupArray);
            }
        }

        if (isset($ingredientDetailToMap['alternate']) && !is_null($ingredientDetailToMap['alternate'])) {
            $ingredientDetailAlternate = $this->mapIngredientDetail($recipe, $ingredientDetailToMap['alternate']);
        }

        return $ingredientDetail = IngredientDetail::create([
            'recipe_id'                     => $recipe->id,
            'amount'                        => $ingredientDetailToMap['amount'],
            'amount_max'                    => $ingredientDetailToMap['amountMax'],
            'unit_id'                       => (isset($obj['unit']) ? $obj['unit']->id : NULL),
            'ingredient_id'                 => $obj['ingredient']->id,
            'prep_id'                       => (isset($obj['prep']) ? $obj['prep']->id : NULL),
            'ingredient_detail_group_id'    => (isset($group) ? $group->id : NULL),
            'position'                      => $ingredientDetailToMap['position'],
            'ingredient_detail_id'          => (isset($ingredientDetailAlternate) ? $ingredientDetailAlternate->id : NULL),
        ]);
    }
}
