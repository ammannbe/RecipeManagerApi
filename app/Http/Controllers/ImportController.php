<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportFormRequest;
use App\Helpers\KremlParser;
use App\Helpers\FormatHelper;
use App\Helpers\FormHelper;
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
        $cookbook = Cookbook::where('name', $request->cookbook)->first();

        $file = [
            'content'   => file_get_contents($request->file),
            'extension' => $request->file->getClientOriginalExtension(),
        ];

        $call = $file['extension'];
        if (method_exists($this, $call)) {
            return $this->$call($file['content'], $cookbook);
        } else {
            return redirect('/recipes/import')
                ->withErrors(['Dieses Format wird nicht unterstützt.'])
                ->withInput();
        }
    }

    public function form() {
        $cookbooks = Cookbook::orderBy('name')->pluck('name', 'id')->toArray();
        return view('recipes.import', compact('cookbooks'));
    }

    private function kreml(String $kreml, Cookbook $cookbook) {
        $parsedRecipes = KremlParser::parse($kreml);

        foreach ($parsedRecipes as $parsedRecipe) {
            unset($author);
            unset($category);

            if (isset($parsedRecipe['author']) && $parsedRecipe['author']) {
                $author = Author::firstOrCreate(['name' => $parsedRecipe['author']]);
            }

            $category = Category::firstOrCreate(['name' => $parsedRecipe['category']]);

            if (isset($parsedRecipe['photo'])) {
                $parsedRecipe['photo']['name'] = FormatHelper::generatePhotoName($parsedRecipe['name'], $parsedRecipe['photo']['extension']);
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
                'category_id'       => $category->id,
                'user_id'           => Auth::user()->id,
                'name'              => $parsedRecipe['name'],
                'yield_amount'      => $parsedRecipe['yieldAmount'],
                'instructions'      => $parsedRecipe['instructions'],
                'photo'             => $parsedRecipe['photo']['name'],
                'preparation_time'  => $parsedRecipe['preparationTime'],
            ]);

            if (isset($parsedRecipe['ingredientDetails'])) {
                foreach ($parsedRecipe['ingredientDetails'] as $parsedIngredientDetail) {
                    $this->mapIngredientDetail($recipe, $parsedIngredientDetail);
                }
            }
        }

        \Toast::info('Rezepte wurden importiert.');
        return redirect('/admin');
    }

    private function mapIngredientDetail(Recipe $recipe, Array $ingredientDetailToMap) {
        if (!isset($ingredientDetailToMap['ingredient']) || is_null($ingredientDetailToMap['ingredient'])) {
            return NULL;
        }

        foreach (['ingredient', 'unit'] as $name) {
            if (isset($ingredientDetailToMap[$name]) && !is_null($ingredientDetailToMap[$name])) {
                $cname = '\\App\\'.ucfirst($name);
                $obj[$name] = $cname::firstOrCreate(['name' => $ingredientDetailToMap[$name]]);
            }
        }

        unset($preps);
        if ($ingredientDetailToMap['preps']) {
            foreach ($ingredientDetailToMap['preps'] as $prep) {
                $preps[] = Prep::firstOrCreate(['name' => $prep])->id;
            }
        }

        if (isset($ingredientDetailToMap['group'])) {
            $groupArray = [
                'name'      => $ingredientDetailToMap['group'],
                'recipe_id' => $recipe->id,
            ];

            $group = IngredientDetailGroup::firstOrCreate($groupArray);
        }

        if (isset($ingredientDetailToMap['alternate']) && !is_null($ingredientDetailToMap['alternate'])) {
            $ingredientDetailAlternate = $this->mapIngredientDetail($recipe, $ingredientDetailToMap['alternate']);
        }

        $ingredientDetail = IngredientDetail::create([
            'recipe_id'                     => $recipe->id,
            'amount'                        => $ingredientDetailToMap['amount'],
            'amount_max'                    => $ingredientDetailToMap['amountMax'],
            'unit_id'                       => (isset($obj['unit']) ? $obj['unit']->id : NULL),
            'ingredient_id'                 => $obj['ingredient']->id,
            'ingredient_detail_group_id'    => (isset($group) ? $group->id : NULL),
            'position'                      => $ingredientDetailToMap['position'],
            'ingredient_detail_id'          => (isset($ingredientDetailAlternate) ? $ingredientDetailAlternate->id : NULL),
        ]);

        if (isset($preps)) {
            $ingredientDetail->preps()->sync($preps);
        }
    }
}
