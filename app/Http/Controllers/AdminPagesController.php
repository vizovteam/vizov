<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;
use Validator;

class AdminPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:60|unique:pages',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $page = new Page;

        if ($request->sort_id > 0)
            $page->sort_id = $request->sort_id;
        else
            $page->sort_id = $page->count() + 1;
        $page->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $page->title = $request->title;
        $page->title_description = $request->title_description;
        $page->meta_description = $request->meta_description;
        $page->text = $request->text;
        if ($request->status == 'on')
            $page->status = 1;
        else
            $page->status = 0;
        $page->save();

        return redirect('/admin/pages')->with('status', 'Страница добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        if ($request->sort_id > 0)
            $page->sort_id = $request->sort_id;
        else
            $page->sort_id = $page->count() + 1;
        $page->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $page->title = $request->title;
        $page->title_description = $request->title_description;
        $page->meta_description = $request->meta_description;
        $page->text = $request->text;
        if ($request->status == 'on')
            $page->status = 1;
        else
            $page->status = 0;
        $page->save();

        return redirect('/admin/pages')->with('status', 'Рубрика обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Page::destroy($id);

        return redirect('/admin/pages')->with('status', 'Страница удалена!');
    }
}