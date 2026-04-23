<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodWaste extends Model
{
    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
