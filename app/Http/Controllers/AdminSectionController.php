<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\Http\Requests\SectionRequest;
use Storage;

class AdminSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $section = Section::orderBy('sort_id')->get();

        return view('admin.section.index', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.section.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SectionRequest $request)
    {
        $section = new Section;

        $count = $section->count();

        if ($request->sort_id > 0) $section->sort_id = $request->sort_id;
        else $section->sort_id = ++$count;
        $section->service_id = $request->service_id;
        $section->title = $request->title;
        $section->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $section->lang = $request->lang;
        if ($request->status == 'on') $section->status = 1;
        else $section->status = 0;
        $section->save();

        return redirect('/admin/section')->with('status', 'Раздел добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $item = Section::findOrFail($id);

        return view('admin.section.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(SectionRequest $request, $id)
    {
        $section = Section::findOrFail($id);
        $count = $section->count();

        if ($request->sort_id > 0) $section->sort_id = $request->sort_id;
        else $section->sort_id = ++$count;
        $section->service_id = $request->service_id;
        $section->title = $request->title;
        $section->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $section->lang = $request->lang;
        if ($request->status == 'on') $section->status = 1;
        else $section->status = 0;
        $section->save();

        return redirect('/admin/section')->with('status', 'Раздел обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);

        $section->delete();

        return redirect('/admin/section')->with('status', 'Раздел удален!');
    }
}