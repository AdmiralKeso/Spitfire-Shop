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
    public function votePost(Request $request, Post $post)
    {
        $request->validate(['vote' => 'required|in:1,-1']);
        $post->castVote(Auth::id(), (int) $request->vote);
        $post->refresh();
        return response()->json([
            'upvotes'  => $post->upvotes,
            'downvotes' => $post->downvotes,
            'userVote' => $post->userVote(),
        ]);
    }
    }
}
