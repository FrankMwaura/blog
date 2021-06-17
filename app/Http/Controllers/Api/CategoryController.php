<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function multipleDelete(Request $request)
    {
        // dd($request);
        foreach($request->all() as $category)
        {
            // dd($category['id']);
            Category::find($category['id'])->delete();
        }
    }

    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function getAllCategory()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id)->delete();
        return $this->index();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required'
        ]);

        Category::create($request->all());
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->update($request->all());
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->index();
    }
}
