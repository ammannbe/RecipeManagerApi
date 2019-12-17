<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('recipe_id');
            $table->float('amount')->nullable()->default(null);
            $table->float('amount_max')->nullable()->default(null);
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('ingredient_detail_group_id')->nullable()->default(null);
            $table->unsignedBigInteger('ingredient_detail_id')->comment('alternate to')->nullable()->default(null);
            $table->integer('position')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->nullable()->default(null);
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('ingredient_detail_group_id')->references('id')->on('ingredient_detail_groups')->onDelete('cascade');
            $table->foreign('ingredient_detail_id')->references('id')->on('ingredient_details')->onDelete('cascade')->nullable()->default(null);
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
