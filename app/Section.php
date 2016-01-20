<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'section';

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function categories()
    {
        return $this->hasMany('App\Category', 'section_id');
    }
}
