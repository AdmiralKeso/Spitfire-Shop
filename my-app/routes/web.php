<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

//Main controller routes
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/forum', [MainController::class, 'forum'])->name('forum');
Route::get('/forum/create', [MainController::class, 'forumCreate'])->name('create')->middleware('auth');
Route::get('/forum/{post}', [MainController::class, 'showPost'])->name('post.show');
Route::post('/forum/create', [MainController::class, 'storePost'])->name('post.store')->middleware('auth');
Route::post('/forum/{post}/vote', [MainController::class, 'votePost'])->name('post.vote')->middleware('auth');
Route::post('/forum/{post}/comment', [MainController::class, 'commentPost'])->name('post.comment')->middleware('auth');
Route::get('/forum/{post}/edit', [MainController::class, 'editPost'])->name('post.edit')->middleware('auth');
Route::put('/forum/{post}', [MainController::class, 'updatePost'])->name('post.update')->middleware('auth');
Route::delete('/forum/{post}', [MainController::class, 'destroyPost'])->name('post.destroy')->middleware('auth');
