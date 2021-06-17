<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;

class BlogController extends Controller
{

    public function index($number = 10)
    {
        $blogs = Blog::latest()->with('category')->paginate($number);

        return response()->json([
            'blogs' => $blogs
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->blogValidation($request);
        $file = '';
        $upload_path = public_path('uploads');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time()."_".$file->getClientOriginalName();
            $file->move($upload_path, $name);
            // dd($name);
        }
        // dd($file);
        
        $blog = new blog();
        $blog->create(array_merge($request->all(), [
            'image' => $name
        ]));
    }

    public function show(Blog $blog)
    {
        //
    }

    public function edit(Blog $blog)
    {
        return response()->json([
            'blog' => $blog
        ], 200);
    }

    public function update(Request $request, Blog $blog)
    {
        dd($request->all());
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->index();
    }

    public function multipleDelete(Request $request)
    {
        // dd($request);
        foreach($request->all() as $blog)
        {
            // dd($blog['id']);
            Blog::find($blog['id'])->delete();
        }
    }

    public function blogValidation($request, $id=null)
    {
        if ($id) {
            $image = '';
        }else{
            $image = 'required|mimes:jpg,jpeg,png,jfif,gif,svg|max:5000';
        }
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'description' => 'required',
                'small_description' => 'required',
                'image' => $image,
            ],
            [
                'category_id.required' => 'The category field is required'
            ]
        );
    }

    public function updateBlog(Request $request, $id)
    {
        // dd($request->all());
        $blog = Blog::findOrFail($id);
        $this->blogValidation($request, $id);
        $this->blogValidation($request);
        $file = '';
        $upload_path = public_path('uploads');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time()."_".$file->getClientOriginalName();
            $file->move($upload_path, $name);
            $image = public_path("uploads/$blog->image");
            if (file_exists($image)) {
                unlink($image);
            }
            // dd($name);
        }else{
            $name = $blog->image;
        }
        // dd($file);

        $blog->update(array_merge($request->all(), [
            'image' => $name
        ]));
    }

    public function getAllBlog()
    {
        if (!\Request::ajax()) {
            return abort(404);
        }
        return $this->index(15);
    }
}
