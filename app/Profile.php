<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'parent');
    }

    public function addFavorite($post_id)
    {
        $favorites = json_decode($this->favorites, true);
        if ($favorites) {
            $favorites[]= $post_id;
        } else {
            $favorites = [$post_id];
        }
        $favorites = array_unique($favorites);
        $this->favorites = json_encode($favorites, JSON_FORCE_OBJECT);
        $this->save();
    }

    public function getFavorites()
    {
        return json_decode($this->favorites, true);
    }

    public function deleteFavorite($post_id)
    {
        $favorites = json_decode($this->favorites, true);

        if ($favorites) {
            $post_position = array_search($post_id, $favorites);

            if($post_position !== false) {
                unset($favorites[$post_position]);
                $this->favorites  = json_encode($favorites, JSON_FORCE_OBJECT);
                $this->save();
            }
        }
        return $this->favorites;
    }

    public function addFavoriteToCookie($request)
    {
        $response = new \Illuminate\Http\Response('adding favorite');
        $favorites = json_decode($request->cookie('favorites'), true);

        if ($favorites) {
            $favorites[] = intval($request->input('post_id'));
        } else {
            $favorites = [intval($request->input('post_id'))];
        }

        $favorites = array_unique($favorites);
        $response->withCookie(cookie()->forever('favorites', json_encode($favorites, JSON_FORCE_OBJECT)));
        return $response;
    }

    public function getFavoritesFromCookie($request)
    {
        return json_decode($request->cookie('favorites'), true);
    }

    public function deleteFavoriteFromCookie($request)
    {
        $response = new \Illuminate\Http\Response('adding favorite');
        $favorites = json_decode($request->cookie('favorites'), true);
        $post_id = intval($request->input('post_id'));

        if ($favorites) {
            $post_position = array_search($post_id, $favorites);

            if($post_position !== false) {
                unset($favorites[$post_position]);
                $response->withCookie(cookie()->forever('favorites', json_encode($favorites, JSON_FORCE_OBJECT)));
            }
        } 

        return $response;
    }
}
