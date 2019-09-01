<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeletes extends Migration
{

    /**
     * The tables that should be changed.
     *
     * @var array
     */
    private  $tables = [
        'authors',
        'categories',
        'ingredients',
        'ingredient_details',
        'ingredient_detail_groups',
        'preps',
        'ratings',
        'rating_criteria',
        'recipes',
        'tags',
        'units',
        'users'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $dbTable) {
            Schema::table($dbTable, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $dbTable) {
            Schema::table($dbTable, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
}
