<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }
}
