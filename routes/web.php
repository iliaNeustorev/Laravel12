<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTrashController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', PostController::class);
Route::resource('post-trash', PostTrashController::class)->except('show', 'create', 'store', 'edit');
Route::resource('categories', CategoryController::class);
Route::patch('/posts/{post}', [ PostController::class, 'publish' ])->name('posts.publish');

Route::resource('shops', ShopController::class);
Route::put('shops/{shop}/detach-all-products', [ShopController::class, 'detachAllProducts']);

