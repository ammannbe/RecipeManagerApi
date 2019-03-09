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
            $table->float('amount_max')->nullable()->default(NULL);
            $table->unsignedInteger('unit_id')->nullable()->default(NULL);
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('ingredient_detail_group_id')->nullable()->default(NULL);
            $table->unsignedInteger('ingredient_detail_id')->comment('alternate')->nullable()->default(NULL);
            $table->integer('position')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->nullable()->default(NULL);
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('ingredient_detail_group_id')->references('id')->on('ingredient_detail_groups')->onDelete('cascade');
            $table->foreign('ingredient_detail_id')->references('id')->on('ingredient_details')->onDelete('cascade')->nullable()->default(NULL);
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
