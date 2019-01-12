<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePhotoInRecipes1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->string('photo')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            DB::statement("ALTER TABLE recipes MODIFY photo MEDIUMBLOB");
        });
    }
}
