<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Profile;
use App\Section;
use App\Http\Requests\ProfileRequest;
use Hash;
use Image;
use Storage;
use App\Post;
use Validator;
use App\Http\Controllers\ProfileController;


class ProfileController extends Controller
{

    public function __construct(Request $request)
    {
        $favorites = ProfileController::getFavorites($request);
        view()->share('favorites', $favorites);
    }

    public function getProfile($id)
    {
        $profile = Profile::find($id);
        $contacts = json_decode($profile->phone);
        $posts = $profile->user->posts()->orderBy('id', 'DESC')->get();
        $first_number = rand(1, 10);
        $second_number = rand(1, 10);

        return view('profile.profile_user', compact('posts', 'profile', 'contacts', 'first_number', 'second_number'));
    }

    public function getProfiles()
    {
        $profiles = Profile::paginate(20);

        return view('profile.profiles_users', compact('profiles'));
    }

    public function getMyProfile()
    {
        $profile = Auth::user()->profile;
        $contacts = json_decode($profile->phone);

    	return view('profile.my_profile', compact('profile', 'contacts'));
    }

    public function editMyProfile()
    {
        $profile = Auth::user()->profile;
        $contacts = json_decode($profile->phone);
        $section = Section::orderBy('sort_id')->where('status', 1)->get();

        return view('profile.my_profile_edit', compact('profile', 'contacts', 'section'));
    }

    public function updateMyProfile(ProfileRequest $request, $id)
    {
        $profile = Auth::user()->profile;

        if ($request->hasFile('avatar'))
        {
            $avatar = 'ava-'.str_random(20).'.'.$request->file('avatar')->getClientOriginalExtension();

            if ( ! file_exists('img/users/'.$profile->user->id))
            {
                Storage::makeDirectory('img/users/'.$profile->user->id);
            }

            $file = Image::make($request->file('avatar'));
            $file->fit(90, null);
            $file->crop(90, 90);
            $file->save('img/users/'.$profile->user->id.'/'.$avatar, 50);

            if ( ! empty($profile->avatar))
            {
                Storage::delete('img/users/'.$profile->user->id.'/'.$profile->avatar);
            }
        }

        $profile->user->name = $request->name;
        $profile->user->save();

        $profile->city_id = $request->city_id;
        if ($request->category_id != 0)
            $profile->category_id = $request->category_id;

        $contacts = [
            'phone' => $request->phone,
            'telegram' => $request->telegram,
            'whatsapp' => $request->whatsapp,
            'viber' => $request->viber,

            'phone2' => $request->phone2,
            'telegram2' => $request->telegram2,
            'whatsapp2' => $request->whatsapp2,
            'viber2' => $request->viber2
        ];

        $profile->phone =  json_encode($contacts);
        $profile->skills = $request->skills;
        $profile->address = $request->address;
        $profile->website = $request->website;
        if (isset($avatar))
            $profile->avatar = $avatar;
        $profile->save();

        return redirect('/my_profile')->with('status', 'Профиль обновлен!');
    }

    public function getMyPosts(Request $request)
    {
        $posts = Post::where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->get();


        $favorites = $this->getFavorites($request);
        $favorites = $favorites ? $favorites : [];

        return view('profile.my_posts', compact('posts', 'favorites'));
    }

    public function getMyReviews()
    {
        $profile = Auth::user()->profile;

        return view('profile.my_reviews', compact('profile'));
    }

    public function getMySetting()
    {
    	return view('profile.my_setting');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:60',
            'new_password' => 'required|confirmed|min:6|max:60',
            'new_password_confirmation' => 'required|min:6|max:60'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }

        if (Hash::check($request->password, Auth::user()->password))
        {
            $user = User::findOrFail(Auth::id());
            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect()->back()->with('status', 'Пароль изменен!');
        }
        else
        {
            return redirect()->back()->withErrors('Пароль не верный!');
        }
    }

    public function deleteAccount(Request $request)
    {
        Auth::user();
    }

    public function showMyFavorites(Request $request) {

        $favorites = $this->getFavorites($request);
        $favorites = $favorites ? $favorites : [];
        $profiles = Profile::take(5)->get();

        $posts = Post::whereIn('id', array_values($favorites))
            ->orderBy('id', 'DESC')
            ->get();

        return view('profile.my_favorites', compact('posts', 'favorites', 'profiles'));

    }

    public function addFavorite(Request $request)
    {
        $post_id = intval($request->input('post_id'));
        if (!$post_id) return;

        $user = auth()->user();
        if ($user && $user->profile()) {
            $user->profile()->first()->addFavorite($post_id);
        } else {
            $profile = new Profile();

            return $profile->addFavoriteToCookie($request);
        }
    }

    public static function getFavorites(Request $request) {
        $user = auth()->user();
        if ($user && $user->profile()) {
            return $user->profile()->first()->getFavorites();
        } else {
            $profile = new Profile();

            return $profile->getFavoritesFromCookie($request);
        }
    }

    public function deleteFavorite(Request $request)
    {
        $post_id = $request->input('post_id');
        if (!$post_id) return;

        $user = auth()->user();
        if ($user && $user->profile()) {
            $user->profile()->first()->deleteFavorite($post_id);
        } else {
            $profile = new Profile();

            return $profile->deleteFavoriteFromCookie($request);
        }
    }
}
