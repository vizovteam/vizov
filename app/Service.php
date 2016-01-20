<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    public function section()
    {
        return $this->hasMany('App\Section', 'service_id');
    }
}
