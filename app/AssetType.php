<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $primaryKey = "id";

    public function asset()
    {
        return $this->hasMany('App\Asset', 'tipe_id', 'id');
    }
}
