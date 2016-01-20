<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service;
use Validator;

class AdminServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();

        return view('admin.services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:60|unique:services',
            'route' => 'required|max:60|unique:services',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = new Service;

        if ($request->sort_id > 0)
            $service->sort_id = $request->sort_id;
        else
            $service->sort_id = $service->count() + 1;
        $service->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $service->title = $request->title;
        $service->route = $request->route;
        $service->title_description = $request->title_description;
        $service->meta_description = $request->meta_description;
        $service->text = $request->text;
        if ($request->status == 'on')
            $service->status = 1;
        else
            $service->status = 0;
        $service->save();

        return redirect('/admin/services')->with('status', 'Сервис добавлен!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.edit', ['service' => $service]);
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
        $service = Service::findOrFail($id);

        if ($request->sort_id > 0)
            $service->sort_id = $request->sort_id;
        else
            $service->sort_id = $service->count() + 1;
        $service->slug = ( ! empty($request->slug)) ? $request->slug : str_slug($request->title);
        $service->title = $request->title;
        $service->route = $request->route;
        $service->title_description = $request->title_description;
        $service->meta_description = $request->meta_description;
        $service->text = $request->text;
        if ($request->status == 'on')
            $service->status = 1;
        else
            $service->status = 0;
        $service->save();

        return redirect('/admin/services')->with('status', 'Сервис обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::destroy($id);

        return redirect('/admin/services')->with('status', 'Сервис удален!');
    }
}
