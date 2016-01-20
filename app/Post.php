<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'sort_id',
		'user_id',
		'city_id',
        'section_id',
        'slug',
        'title',
        'title_description',
        'meta_description',
        'price',
        'deal',
        'description',
        'image',
        'images',
        'address' ,
        'phone',
        'email',
        'comment',
        'lang',
        'views',
        'status'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('j '.trans('date.month.'.date('F', strtotime($value))).', Y', strtotime($value));
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'parent');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function hasTag( $id )
    {
        $tags = $this->tags()->get();

        foreach( $tags as $tag ) {
            if( $tag->id == $id ) {
                return true;
            }
        }

        return false;
    }

    public function attachTags( $tags_id )
    {
        $this->tags()->attach( $tags_id );
    }

    public function detachTags( $tags_id = NULL )
    {
        if( $tags_id ) {
            $this->tags()->detach( $tags_id);
        } else {
            $this->tags()->detach();
        }
    }
}
