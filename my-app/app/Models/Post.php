<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'genre', 'description', 'content', 'upvotes', 'downvotes'];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(PostVote::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class)->with('user')->latest();
    }

    // ── Votes ──────────────────────────────────────────────────────────────────

    public function userVote(): ?int
    {
        if (!Auth::check()) return null;
        return $this->votes()->where('user_id', Auth::id())->first()?->vote;
    }

    public function castVote(int $userId, int $vote): void
    {
        $existing = $this->votes()->where('user_id', $userId)->first();

        if ($existing) {
            if ($existing->vote === $vote) {
                $existing->delete();
                $this->decrement($vote === 1 ? 'upvotes' : 'downvotes');
            } else {
                $existing->update(['vote' => $vote]);
                $this->increment($vote === 1 ? 'upvotes' : 'downvotes');
                $this->decrement($vote === 1 ? 'downvotes' : 'upvotes');
            }
        } else {
            $this->votes()->create(['user_id' => $userId, 'vote' => $vote]);
            $this->increment($vote === 1 ? 'upvotes' : 'downvotes');
        }
    }

    // ── Comments ───────────────────────────────────────────────────────────────

    public function addComment(int $userId, string $body): void
    {
        $this->comments()->create(['user_id' => $userId, 'body' => $body]);
    }
}
