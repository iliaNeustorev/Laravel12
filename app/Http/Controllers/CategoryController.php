<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\SaveRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('title')->get();
        return view('categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveRequest $request)
    {
        $data = $request->validated();
        Category::create($data);
        return redirect()->route('categories.index')->with('notice', 'categories.created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('posts:id,category_id,title');
        return view('categories/show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        return redirect()->route('categories.index')->with('notice', 'categories.updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $postsCnt = $category->posts()->count();

        if($postsCnt >= 1) {
            abort(403, 'Please before remove posts:' . $postsCnt);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('notice', 'categories.deleted');
    }
}
