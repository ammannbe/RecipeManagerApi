<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cookbook_id')->nullable()->default(null);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('author_id')->nullable()->default(null);
            $table->string('name', 100)->unique();
            $table->string('slug', 200)->unique();
            $table->decimal('yield_amount', 3, 0)->nullable()->default(4);
            $table->enum('complexity', ['simple', 'normal', 'difficult'])->default('normal');
            $table->mediumtext('instructions');
            $table->string('photo')->nullable()->default(null);
            $table->time('preparation_time')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

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
