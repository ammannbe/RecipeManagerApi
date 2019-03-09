<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientDetailPrepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_detail_prep', function (Blueprint $table) {
            $table->unsignedInteger('ingredient_detail_id')->onDelete('cascade');
            $table->unsignedInteger('prep_id');

            $table->foreign('ingredient_detail_id')->references('id')->on('ingredient_details');
            $table->foreign('prep_id')->references('id')->on('preps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_detail_prep');
    }
}
