<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('cookbook_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('author_id')->nullable()->default(NULL);
            $table->string('name', 191);
            $table->decimal('yield_amount', 3, 0)->nullable()->default(4);
            $table->mediumtext('instructions');
            $table->string('photo', 191)->nullable()->default(NULL);
            $table->time('preparation_time')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cookbook_id')->references('id')->on('cookbooks');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
