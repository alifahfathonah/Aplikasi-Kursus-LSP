<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'users';

    public function getRouteKeyName()
    {
        return 'username';
    }
}
