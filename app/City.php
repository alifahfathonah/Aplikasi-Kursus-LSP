<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    public function asset()
    {
        return $this->hasMany('App\Asset', 'kota', 'id');
    }
}
