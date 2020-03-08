<?php

namespace App\Observers\Ingredients;

use App\Models\Ingredients\Unit;

class UnitObserver
{
    /**
     * Handle the unit "creating" event.
     *
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return void
     */
    public function creating(Unit $unit)
    {
        $unit->author_id = auth()->user()->author->id;
    }

    /**
     * Handle the unit "saving" event.
     *
     * @param  \App\Models\Ingredients\Unit  $unit
     * @return void
     */
    public function saving(Unit $unit)
    {
        $unit->slugifyName();
    }
}
