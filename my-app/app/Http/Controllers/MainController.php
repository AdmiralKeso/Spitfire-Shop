<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function showPost(Post $post)
    {
        $comments = $post->comments()->get();
        return view('forum.show', compact('post', 'comments'));
    }

    public function editPost(Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403);
        return view('forum.edit', compact('post'));
    }

    public function updatePost(Request $request, Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'content'     => 'required|string',
        ]);

        $post->update($request->only('title', 'genre', 'description', 'content'));

        return redirect()->route('post.show', $post)->with('success', 'Post updated!');
    }

    public function destroyPost(Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403);
        $post->delete();
        return redirect()->route('forum')->with('success', 'Post deleted.');
    }

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

    public function commentPost(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string|max:300']);
        $post->addComment(Auth::id(), $request->body);
        return back();
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'content'     => 'required|string',
        ]);

        Post::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'genre'       => $request->genre,
            'description' => $request->description,
            'content'     => $request->content,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['redirect' => route('forum')]);
        }

        return redirect()->route('forum')->with('success', 'Post created!');
    }
}
