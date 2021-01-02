<?php

use App\Models\Recipes\Recipe;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->morphs('model');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');
            $table->unsignedInteger('order_column')->nullable();

            $table->nullableTimestamps();
        });

        \File::moveDirectory(storage_path('app/images/recipes'), storage_path('app/images/recipes.old'));
        \Storage::disk('recipe_photos')->makeDirectory('');
        \File::copy(storage_path('app/images/recipes.old/.gitignore'), storage_path('app/images/recipes/.gitignore'));
        Recipe::withoutGlobalScopes()->whereNotNull('photos')->each(function (Recipe $recipe) {
            if (!\File::exists(storage_path("app/images/recipes.old/{$recipe->id}"))) {
                return;
            }

            $files = \File::files(storage_path("app/images/recipes.old/{$recipe->id}"));

            foreach ($files as $file) {
                $recipe->addMedia($file->getPathname())->toMediaCollection('recipe_photos');
            }
        });

        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');

        Schema::table('recipes', function (Blueprint $table) {
            $table->json('photos')->nullable()->default(null)->after('insructions');
        });
    }
}
