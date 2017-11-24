<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //

    protected $table = 'admins';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'admin_role', 'admin_id', 'role_id')->withTimestamps();
    }
}
