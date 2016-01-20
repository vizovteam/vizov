<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\Category;
use App\Tag;

class AdminTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        $categories = Category::all();

        return view('admin.tags.index', compact('tags', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = Section::all();

        return view('admin.tags.create', compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'category_id' => 'required|numeric',
        ]);

        $tag = new Tag;

        $count = $tag->count();

        if ($request->sort_id > 0)
            $tag->sort_id = $request->sort_id;
        else
            $tag->sort_id = ++$count;
        $tag->category_id = $request->category_id;
        $tag->slug = str_slug($request->title);
        $tag->title = $request->title;
        if ($request->status == 'on')
            $tag->status = 1;
        else
            $tag->status = 0;
        $tag->save();

        return redirect()->back()->with('status', 'Тег создан!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $section = Section::all();

        return view('admin.tags.edit', compact('tag', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'category_id' => 'required|numeric',
        ]);

        $tag = Tag::findOrFail($id);

        if ($request->sort_id > 0)
            $tag->sort_id = $request->sort_id;
        $tag->category_id = $request->category_id;
        $tag->slug = str_slug($request->title);
        $tag->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $tag->title = $request->title;
        if ($request->status == 'on')
            $tag->status = 1;
        else
            $tag->status = 0;
        $tag->save();

        return redirect('admin/tags')->with('status', 'Тег обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);

        return redirect('admin/tags')->with('status', 'Тег удален!');
    }
}
