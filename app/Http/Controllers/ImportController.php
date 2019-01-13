<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportFormRequest;
use App\Author;
use App\Category;
use App\Recipe;
use App\Cookbook;
use Toast;
use Parser;
use Auth;

class ImportController extends Controller
{
    public function index(ImportFormRequest $request) {
        $input = $request->all();
        $file = [];
        $file['content'] = file_get_contents($input['file']);
        $file['extension'] = $input['file']->getClientOriginalExtension();
        try {
            $file['parsed'] = Parser::xml($file['content']);
        } catch (\Exception $ex) {
            Toast::error('Diese Datei kann nicht importiert werden.');
            return redirect('/recipes/import');
        }

        $call = $file['extension'];
        if (method_exists($this, $call)) {
            return $this->$call($file['parsed'], $request);
        } else {
            Toast::error('Dieses Format wird nicht unterstützt.');
            return redirect('/recipes/import');
        }
    }

    public function form() {
        $cookbooks[NULL] = '-- SELECT --';
        foreach (Cookbook::orderBy('name')->get() as $cookbook) {
            $cookbooks[$cookbook->id] = $cookbook->name;
        }

        return view('recipes.import', compact('cookbooks'));
    }

    private function kreml(Array $parsedXml, Request $request) {

        foreach ($parsedXml['krecipes-recipe'] as $recipeXml) {
            if (isset($recipeXml['krecipes-description']['author'])) {
                $authorName = $recipeXml['krecipes-description']['author'];
                if ($authorFound = Author::where('name', $authorName)->first()) {
                    $author_id = $authorFound->id;
                } else {
                    $authorNew = Author::create(['name' => $authorName]);
                    $author_id = $authorNew->id;
                }
            } else {
                $author_id = NULL;
            }

            if (!is_null($recipeXml['krecipes-description']['pictures'])) {
                $photoBase64    = $recipeXml['krecipes-description']['pictures']['pic']['#text'];
                $photoExtension = strtolower($recipeXml['krecipes-description']['pictures']['pic']['@format']);
                $photoName      = time().'.'.$photoExtension;
                $photoPath      = public_path().'/images/recipes/'.$photoName;
    
                if (file_put_contents($photoPath, base64_decode($photoBase64))) {
                    Toast::error('Fehler beim Hochladen des Bildes für Rezept "' . $recipeXml['krecipes-description']['title'] . '"');
                }
            } else {
                $photoName = NULL;
            }

            $recipe = Recipe::create([
                'author_id'     => $author_id,
                'cookbook_id'   => $request->input('cookbook_id'),
                'user_id'       => Auth::user()->id,
                'name'          => $recipeXml['krecipes-description']['title'],
                'yield_amount'  => $recipeXml['krecipes-description']['yield']['amount'],
                'instructions'  => $recipeXml['krecipes-instructions'],
                'photo'         => $photoName,
                'preparation_time'  => $recipeXml['krecipes-description']['preparation-time'],
            ]);


            if (is_array($recipeXml['krecipes-description']['category']['cat'])) {
                $categoryNames = $recipeXml['krecipes-description']['category']['cat'];
            } else {
                $categoryNames[] = $recipeXml['krecipes-description']['category']['cat'];
            }

            foreach ($categoryNames as $key => $categoryName) {
                if (! $category = Category::where(['name' => $categoryName])->get()->first()) {
                    $category = Category::create(['name' => $categoryName]);
                }
                $recipe->categories()->sync($category->id);
            }
        }


        Toast::success('Rezept(e) erfolgreich importiert.');
        return redirect('/');
    }
}
