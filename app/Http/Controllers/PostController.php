<?php

namespace App\Http\Controllers;

use App\Enums\Posts\Status;
use App\Http\Requests\Post\FilterRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $filters = $request->validated();
        $posts = Post::with('category:id,title', 'user')
            ->filter($filters)
            ->orderByDesc('updated_at')
            ->get();
        $statuses = collect(Status::TEXTS);
        $categories = Category::pluck('title', 'id');
        return view('posts/index', compact('posts', 'statuses', 'filters', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id');
        return view('posts/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Gate::authorize('create', Post::class);
        $user = $request->user();
        $data = $request->validated();
        Post::create($data + ['user_id' => $user->id]);
        return redirect()->route('posts.index')->with('notice', 'posts.created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('category:id,title');
        return view('posts/show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::pluck('title', 'id');
        return view('posts/edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        Gate::authorize('update', $post);
        $data = $request->validated();
        $post->update($data);
        return redirect()->route('posts.index')->with('notice', 'posts.updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('notice', 'posts.deleted');
    }

    /**
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function publish(Post $post)
    {
        if($post->status !== Status::DRAFT) {
            abort(400);
        }
        $post->status = Status::MODERATING;
        $post->save();
        return redirect()->route('posts.index')->with('notice', 'posts.updated');
    }
}
