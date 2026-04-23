<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
