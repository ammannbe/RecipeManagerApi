<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCookbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign(['cookbook_id']);
            $table->dropColumn('cookbook_id');
        });

        Schema::dropIfExists('cookbooks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->unsignedInteger('cookbook_id')->after('user_id');
            $table->foreign('cookbook_id')->references('id')->on('cookbooks');
        });

        Schema::create('cookbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
