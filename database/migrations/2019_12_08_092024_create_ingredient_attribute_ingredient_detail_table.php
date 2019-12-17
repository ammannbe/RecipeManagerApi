<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientAttributeIngredientDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_attribute_ingredient_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('ingredient_detail_id');
            $table->unsignedBigInteger('ingredient_attribute_id');

            $table->foreign('ingredient_detail_id', 'ingredient_attribute_ingredient_detail_detail_id_foreign')->references('id')->on('ingredient_details')->onDelete('cascade');
            $table->foreign('ingredient_attribute_id', 'ingredient_attribute_ingredient_detail_attribute_id_foreign')->references('id')->on('ingredient_attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_attribute_ingredient_detail');
    }
}
