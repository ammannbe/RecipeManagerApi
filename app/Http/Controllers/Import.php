<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Category;
use App\Recipe;
use App\Cookbook;
use Toast;
use Parser;
use Auth;

class Import extends Controller
{
    public function index(Request $request) {
        $input = $request->all();
        $file = [];
        $file['content'] = file_get_contents($input['file']);
        $file['extension'] = $input['file']->getClientOriginalExtension();
        $file['parsed'] = Parser::xml($file['content']);

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
        if (!empty($request->file('photo'))) {
            $photo = file_get_contents($request->file('photo'));
        } else {
            $photo = NULL;
        }

        $author = [];
        $author['name'] = $parsedXml['krecipes-recipe']['krecipes-description']['author'];
        if (! $author_id = Author::where('name', $author['name'])->first()->id) {
            $author = Author::create(['name' => $author['name']]);
            $author_id = $author->id;
        }

        $recipe = Recipe::create([
            'author_id'     => $author_id,
            'cookbook_id'   => $request->input('cookbook_id'),
            'user_id'       => Auth::user()->id,
            'name'          => $parsedXml['krecipes-recipe']['krecipes-description']['title'],
            'yield_amount'  => $parsedXml['krecipes-recipe']['krecipes-description']['yield']['amount'],
            'instructions'  => $parsedXml['krecipes-recipe']['krecipes-instructions'],
            'photo'         => $photo,
            'preparation_time'  => $parsedXml['krecipes-recipe']['krecipes-description']['preparation-time'],
        ]);

        $categoryNames = $parsedXml['krecipes-recipe']['krecipes-description']['category']['cat'];
        foreach ($categoryNames as $key => $categoryName) {
            if (! $category = Category::where(['name' => $categoryName])->get()->first()) {
                $category = Category::create(['name' => $categoryName]);
            }
            $recipe->categories()->attach($category->id);
        }

        Toast::success('Rezept erfolgreich importier.');
        return redirect('/recipes/'.$recipe->id);
    }
}
