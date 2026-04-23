<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    public function foodWaste()
    {
        return $this->belongsTo(FoodWaste::class);
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }
}
