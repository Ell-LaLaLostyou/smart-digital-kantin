<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToCanteen;

class DssResult extends Model
{
    use BelongsToCanteen;

    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
