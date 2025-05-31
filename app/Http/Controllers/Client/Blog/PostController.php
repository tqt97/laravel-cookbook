<?php

namespace App\Http\Controllers\Client\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function __invoke(Post $post): View
    {
        $post->increment('view_count');
        $post->loadCount(['comments']);

        $comments = $post->comments()
            ->with('user', 'children.user')
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('client.blogs.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }
}
