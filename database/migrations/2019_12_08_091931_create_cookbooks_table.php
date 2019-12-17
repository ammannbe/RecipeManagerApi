<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cookbooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20);
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cookbooks');
    }
}
