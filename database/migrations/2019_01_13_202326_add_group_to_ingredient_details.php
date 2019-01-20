<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupToIngredientDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_details', function (Blueprint $table) {
            $table->unsignedInteger('ingredient_detail_group_id')->after('prep_id')->nullable()->default(NULL);
            $table->foreign('ingredient_detail_group_id')->references('id')->on('ingredient_detail_groups');
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
            $table->dropForeign(['ingredient_detail_group_id']);
            $table->dropColumn('ingredient_detail_group_id');
        });
    }
}
