<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportFormRequest;
use App\Helpers\KremlParser;
use App\Helpers\FormatHelper;
use App\Helpers\FormHelper;
use App\Models\Author;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\IngredientDetail;
use App\Models\IngredientDetailGroup;
use App\Models\Unit;
use App\Models\Prep;
use Auth;

class ImportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.import');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ImportFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportFormRequest $request)
    {
        $file = [
            'content'   => file_get_contents($request->file),
            'extension' => $request->file->getClientOriginalExtension(),
        ];

        $call = $file['extension'];
        return $this->$call($file['content']);
    }

    /**
     * Import recipes in the kreml file format
     *
     * @param string $kreml
     * @return \Illuminate\Http\Response
     */
    private function kreml(string $kreml)
    {
        $parsedRecipes = KremlParser::parse($kreml);

        foreach ($parsedRecipes as $pRecipe) {
            $author = $category = null;

            if ($pRecipe['author']['name']) {
                $author = Author::firstOrCreate(['name' => $pRecipe['author']['name']]);
            }

            $category = Category::firstOrCreate(['name' => $pRecipe['category']['name']]);

            if ($pRecipe['photo']['extension']) {
                $pRecipe['recipe']['photo'] = FormatHelper::generatePhotoName($pRecipe['recipe']['name'], $pRecipe['photo']['extension']);
                $pRecipe['photo']['path'] = public_path() . '/images/recipes/' . $pRecipe['recipe']['photo'];
                file_put_contents($pRecipe['photo']['path'], base64_decode($pRecipe['photo']['base64']));
            }

            $recipe = Recipe::create(
                array_merge(
                    $pRecipe['recipe'],
                    [
                        'author_id'         => ($author ? $author->id : null),
                        'category_id'       => $category->id,
                        'user_id'           => auth()->user()->id,
                        'slug'              => FormatHelper::slugify($pRecipe['recipe']['name']),
                    ]
                )
            );

            if ($pRecipe['ingredient_details']) {
                foreach ($pRecipe['ingredient_details'] as $ingredientDetail) {
                    $this->addIngredientDetail($recipe, $ingredientDetail);
                }
            }
        }

        \Toast::info(__('import.success'));
        return redirect()->route('admin.index');
    }

    /**
     * Add an ingredient detail to the given recipe
     *
     * @param \App\Modles\Recipe $recipe
     * @param array $ingredientDetail
     * @param IngredientDetail $alternateTo
     */
    private function addIngredientDetail(Recipe $recipe, array $ingredientDetail, IngredientDetail $alternateTo = null)
    {
        if (!isset($ingredientDetail['ingredient']) || !$ingredientDetail['ingredient']) {
            return;
        }
        $ingredient = $unit = $preps = $group = null;

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
                $this->addIngredientDetail($recipe, $alternate, $ingredientDetail);
            }
        }
    }
}
