<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->float('amount')->nullable()->default(NULL);
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('prep_id');
            $table->integer('position')->nullable()->default(NULL);
            $table->unsignedInteger('ingredient_detail_id')->comment('alternate')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->foreign('unit_id')->references('id')->on('units')->nullable()->default(NULL);
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('prep_id')->references('id')->on('preps');
            $table->foreign('ingredient_detail_id')->references('id')->on('ingredient_details')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_details');
    }
}
