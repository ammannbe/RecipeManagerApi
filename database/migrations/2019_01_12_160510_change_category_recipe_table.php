<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCategoryRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_recipe', function (Blueprint $table) {
            $table->dropForeign(['recipe_id']);
            $table->dropForeign(['category_id']);

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_recipe', function (Blueprint $table) {
            $table->dropForeign(['recipe_id']);
            $table->dropForeign(['category_id']);

            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
}
