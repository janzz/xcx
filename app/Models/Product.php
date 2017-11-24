<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function categorys()
    {
        return $this->belongsToMany('App\Models\Category')->withTimestamps();
    }

    public function covers()
    {
        return $this->hasMany('App\Models\Cover');
    }

    public function banners()
    {
        return $this->hasMany('App\Models\Banner');
    }
}

