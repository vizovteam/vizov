<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Profile;
use App\City;
use App\Section;
use Image;
use Storage;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $profiles = Profile::paginate(50);

        return view('admin.users.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        $posts = $profile->user->posts()->orderBy('id', 'DESC')->get();

        return view('admin.users.show', compact('profile', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        $section = Section::all();

        return view('admin.users.edit', compact('profile', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if ($request->hasFile('avatar'))
        {
            $avatar = 'ava-'.str_random(20).'.'.$request->file('avatar')->getClientOriginalExtension();

            if ( ! file_exists('img/users/'.$profile->user->id))
            {
                Storage::makeDirectory('img/users/'.$profile->user->id);
            }

            $file = Image::make($request->file('avatar'));
            $file->fit(250, null);
            $file->crop(250, 250);
            $file->save('img/users/'.$profile->user->id.'/'.$avatar, 50);

            if ( ! empty($profile->avatar))
            {
                Storage::delete('img/users/'.$profile->user->id.'/'.$profile->avatar);
            }
        }

        // $profile->user->email = $request->email;
        $profile->user->name = $request->name;
        $profile->user->status = $request->status;
        $profile->user->save();

        $profile->sort_id = $request->sort_id;
        $profile->city_id = $request->city_id;
        if ($request->section_id != 0)
            $profile->section_id = $request->section_id;
        $profile->stars =  $request->stars;
        $profile->phone =  $request->phone;
        $profile->skills = $request->skills;
        $profile->address = $request->address;
        $profile->website = $request->website;
        if (isset($avatar))
            $profile->avatar = $avatar;
        $profile->status = $request->status;
        $profile->save();

        return redirect()->route('admin.users.index')->with('status', 'Профиль обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

