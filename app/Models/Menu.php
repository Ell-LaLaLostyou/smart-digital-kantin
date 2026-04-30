<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToCanteen;

class Menu extends Model
{
    use BelongsToCanteen;

    protected $guarded = [];

    public function preorders()
    {
        return $this->hasMany(Preorder::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function foodWastes()
    {
        return $this->hasMany(FoodWaste::class);
    }

    public function dssResults()
    {
        return $this->hasMany(DssResult::class);
    }

    public function simulations()
    {
        return $this->hasMany(Simulation::class);
    }
}
