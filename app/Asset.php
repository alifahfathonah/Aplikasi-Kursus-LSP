<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $primaryKey = "id";

    public function assetType(){ 
        return $this->belongsTo('App\AssetType'); 
    }
}
