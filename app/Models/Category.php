<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categorys';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withTimestamps();
    }
}
