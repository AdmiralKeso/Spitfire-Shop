<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/forum', [MainController::class, 'forum'])->name('forum');
Route::get('/forum/create', [MainController::class, 'forumCreate'])->name('create');
Route::get('/account', [MainController::class, 'account'])->name('account');
