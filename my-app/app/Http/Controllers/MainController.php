<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController
{
    public function index()
    {
        return view('index');
    }
    public function forum(Request $request)
    {
        $genre  = $request->query('genre');
        $filter = $request->query('filter');

        $posts = Post::with('user')->withCount('comments')
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->when($filter === 'mine' && Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
            ->latest()
            ->get();
        $trending = Post::with('user')
            ->where('upvotes', '>', 0)
            ->orderByDesc('upvotes')
            ->limit(10)
            ->get();
        if ($request->expectsJson()) {
            return response()->json([
                'posts' => $posts->map(fn($post) => [
                    'id'             => $post->id,
                    'title'          => $post->title,
                    'description'    => $post->description,
                    'genre'          => $post->genre,
                    'user_name'      => $post->user->name,
                    'upvotes'        => $post->upvotes,
                    'downvotes'      => $post->downvotes,
                    'comments_count' => $post->comments_count,
                    'url'            => route('post.show', $post),
                    'vote_url'       => route('post.vote', $post),
                    'user_vote'      => $post->userVote(),
                ]),
                'genre'       => $genre,
                'filter'      => $filter,
                'is_guest'    => !Auth::check(),
                'account_url' => route('account'),
                'csrf'        => csrf_token(),
            ]);
        }

        return view('forum.forum', compact('posts', 'genre', 'filter', 'trending'));
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
