<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Bican\Roles\Models\Role;

class AdminController extends Controller
{
    public function createRoles()
    {
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        Role::create([
            'name' => 'Moderator',
            'slug' => 'moderator',
        ]);

        Role::create([
            'name' => 'User',
            'slug' => 'user',
        ]);
    }

    public function postAdmin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'city_id' => 'required|numeric',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
            'rules' => 'accepted'
        ]);

        $user = \App\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ip' => $request->ip(),
            'location' => serialize($request->ips()),
        ]);

        $user->attachRole(1);

        return redirect()->back()->with('status', 'Admin created!');
    }
}
