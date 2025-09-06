<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::onlyTrashed()->get();
        return view('posts/trash/index', compact('posts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $postTrashId)
    {
        $postTrash = Post::onlyTrashed()->where('id', $postTrashId)->firstOrFail();
        $postTrash->restore();
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postTrashId)
    {
        $postTrash = Post::onlyTrashed()->where('id', $postTrashId)->firstOrFail();
        $postTrash->forceDelete();
        return redirect()->route('post-trash.index');
    }
}
