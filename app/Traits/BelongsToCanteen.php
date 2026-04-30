<?php

namespace App\Traits;

use App\Models\Canteen;
use App\Models\Scopes\CanteenScope;
use Illuminate\Database\Eloquent\Model;

trait BelongsToCanteen
{
    protected static function booted()
    {
        static::addGlobalScope(new CanteenScope);

        static::creating(function (Model $model) {
            if (auth()->check() && auth()->user()->canteen_id && !$model->canteen_id) {
                $model->canteen_id = auth()->user()->canteen_id;
            }
        });
    }

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }
}
