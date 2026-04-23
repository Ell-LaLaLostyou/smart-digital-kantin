<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['name', 'address', 'contact_person', 'phone', 'description', 'need_level'];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
