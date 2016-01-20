<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Post;
use App\Section;
use Image;
use Storage;
use App\Http\Requests\PostRequest;


class AdminPostsController extends Controller
{
    protected $file;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::paginate(20);
        $section = Section::where('service_id', '1')->where('status', 1)->orderBy('sort_id')->get();

        return view('admin.posts.index', compact('posts', 'section'));
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
        $post = Post::findOrFail($id);
        $contacts = json_decode($post->phone);
        $section = Section::where('service_id', '1')->where('status', 1)->orderBy('sort_id')->get();

        return view('admin.posts.edit', compact('post', 'contacts', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->hasFile('images'))
        {
            $i = 0;
            $introImage = null;
            $images = (unserialize($post->images)) ? unserialize($post->images) : [];

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image))
                {
                    $imageName = $key.'-image-'.str_random(10).'.'.$image->getClientOriginalExtension();

                    if ( ! file_exists('img/posts/'.$post->user_id))
                    {
                        Storage::makeDirectory('img/posts/'.$post->user_id);
                    }

                    if ($key == 0)
                    {
                        if ($post->image != NULL AND file_exists('img/posts/'.$post->user_id.'/'.$post->image))
                        {
                            Storage::delete('img/posts/'.$post->user_id.'/'.$post->image);
                        }

                        $mainFile = Image::canvas(300, 200, '#ffffff');
                        $introFile = Image::make($image);

                        $this->file = $introFile;
                        $this->optimalResize(300, 200);

                        $mainFile->insert($this->file, 'center');
                        $mainFile->rectangle(0, 0, 299, 199, function ($draw) {
                            $draw->border(1, '#dddddd');
                        });
                        $mainFile->save('img/posts/'.$post->user_id.'/main-'.$imageName);
                        $introImage = 'main-'.$imageName;
                    }

                    // Creating images
                    $moreFile = Image::canvas(634, 432, '#ffffff');
                    $file = Image::make($image);

                    $this->file = $file;
                    $this->optimalResize(634, 432);

                    $moreFile->insert($this->file, 'center');
                    $moreFile->insert('img/watermark-blue.png', 'bottom-left', 10, 10);
                    $moreFile->rectangle(0, 0, 633, 431, function ($draw) {
                        $draw->border(1, '#dddddd');
                    });
                    $moreFile->save('img/posts/'.$post->user_id.'/'.$imageName);

                    // Creating mini images
                    $miniFile = Image::canvas(95, 71, '#ffffff');

                    $this->file = $file;
                    $this->optimalResize(95, 71);

                    $miniFile->insert($this->file, 'center');
                    $miniFile->rectangle(0, 0, 94, 70, function ($draw) {
                        $draw->border(1, '#dddddd');
                    });
                    $miniFile->save('img/posts/'.$post->user_id.'/mini-'.$imageName);

                    if (isset($images[$key]))
                    {
                        Storage::delete([
                            'img/posts/'.$post->user_id.'/'.$images[$key]['image'],
                            'img/posts/'.$post->user_id.'/'.$images[$key]['mini_image']
                        ]);

                        $images[$key]['image'] = $imageName;
                        $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                    else
                    {
                        $images[$key]['image'] = $imageName;
                        $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                }
            }

            $images = array_sort_recursive($images);
            $images = serialize($images);
        }

        $post->city_id = $request->city_id;
        $post->category_id = $request->category_id;
        $post->slug = str_slug($request->title);
        $post->title = $request->title;
        $post->price = $request->price;
        $post->deal = $request->deal;
        $post->description = $request->description;
        if (isset($introImage)) $post->image = $introImage;
        if (isset($images)) $post->images = $images;
        $post->address = $request->address;
        $post->phone = $request->phone;
        $post->email = $request->email;
        $post->comment = $request->comment;
        if ($request->status == 'on') $post->status = 1;
        else $post->status = 0;
        $post->save();

        return redirect('admin/posts')->with('status', 'Объявление обновлено!');
    }

    public function optimalResize($width, $height)
    {
        if ($this->file->width() <= $this->file->height())
        {
            $this->file->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else
        {
            $this->file->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($this->file->width() > $width OR $this->file->height() > $height)
            $this->file->crop($width, $height);
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
