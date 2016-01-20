<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'category_id');
    }

    public function profiles()
    {
    	return $this->hasMany('App\Profile', 'category_id');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag', 'category_id');
    }
}