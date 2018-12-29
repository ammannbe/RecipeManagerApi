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
            $table->unsignedInteger('cookbook_id');
            $table->unsignedInteger('author_id');
            $table->string('name', 200);
            $table->decimal('yield_amount', 3, 0)->nullable()->default(4);
            $table->mediumtext('instructions');
            $table->binary('photo')->nullable()->default(NULL);
            $table->time('preparation_time')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('cookbook_id')->references('id')->on('recipes');
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
