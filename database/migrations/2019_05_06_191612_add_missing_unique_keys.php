<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingUniqueKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('name', 20)->unique()->change();
        });
        Schema::table('preps', function (Blueprint $table) {
            $table->string('name', 40)->unique()->change();
        });
        Schema::table('ingredients', function (Blueprint $table) {
            $table->string('name', 50)->unique()->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name', 50)->unique()->change();
        });
        Schema::table('authors', function (Blueprint $table) {
            $table->string('name', 50)->unique()->change();
        });
        Schema::table('rating_criteria', function (Blueprint $table) {
            $table->string('name', 20)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropUnique('units_name_unique');
        });
        Schema::table('preps', function (Blueprint $table) {
            $table->dropUnique('preps_name_unique');
        });
        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropUnique('ingredients_name_unique');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_name_unique');
        });
        Schema::table('authors', function (Blueprint $table) {
            $table->dropUnique('authors_name_unique');
        });
        Schema::table('rating_criteria', function (Blueprint $table) {
            $table->dropUnique('rating_criteria_name_unique');
        });
    }
}
