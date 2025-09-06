<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTrashController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', PostController::class);
Route::resource('post-trash', PostTrashController::class)->except('show', 'create', 'store', 'edit');
Route::resource('categories', CategoryController::class);
Route::patch('/posts/{post}', [ PostController::class, 'publish' ])->name('posts.publish');
