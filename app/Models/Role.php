<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function menus()
    {
        return $this->belongsToMany('App\Models\Menu')->withTimestamps();
    }

    public function accounts()
    {
        return $this->belongsToMany('App\Models\Account', 'admin_role', 'role_id', 'admin_id')->withTimestamps();
    }
}
