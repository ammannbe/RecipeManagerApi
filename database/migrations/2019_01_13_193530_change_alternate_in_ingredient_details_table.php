<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAlternateInIngredientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_details', function (Blueprint $table) {
            $table->dropForeign(['ingredient_detail_id']);
            $table->foreign('ingredient_detail_id')->references('id')->on('ingredient_details')->onDelete('cascade');
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
            $table->dropForeign(['ingredient_detail_id']);
            $table->foreign('ingredient_detail_id')->references('id')->on('ingredient_details');
        });
    }
}
