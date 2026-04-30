<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToCanteen;

class Donation extends Model
{
    use BelongsToCanteen;

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
