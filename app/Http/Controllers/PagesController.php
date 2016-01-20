<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;

class PagesController extends Controller
{
    public function page($page)
    {
        $page = Page::where('slug', $page)->first();

        return view('pages.index', compact('page'));
    }
}
