<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIngredientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_details', function (Blueprint $table) {
            $table->dropForeign(['recipe_id']);
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredient_details', function (Blueprint $table) {
            $table->dropForeign(['recipe_id']);
            $table->foreign('recipe_id')->references('id')->on('recipes');
        });
    }
}
