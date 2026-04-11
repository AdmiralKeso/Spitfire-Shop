<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MainController
{
    public function index()
    {
        return view('index');
    }
    public function forum()
    {
        return view('forum.forum');
    }
    public function forumCreate()
    {
        return view('forum.create');
    }
    public function account()
    {
        return view('auth.acc');
    }
}
