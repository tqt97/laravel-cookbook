<?php

namespace App\Http\Controllers\Client\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __invoke(Request $request, string $type, int $id)
    {
        $model = match ($type) {
            'post' => \App\Models\Post::class,
            'comment' => \App\Models\Comment::class,
            default => abort(404),
        };

        $likeable = $model::findOrFail($id);
        $userId = auth()->id();
        $liked = $likeable->likes()->where('user_id', $userId)->first();

        if ($liked) {
            $liked->delete();
            $message = 'Like removed';
        } else {
            $likeable->likes()->create(['user_id' => $userId]);
            $message = 'Like added';
        }

        $likeCount = $likeable->likes()->count();

        if ($request->ajax()) {
            return response()->json([
                'likes' => $likeCount,
                'liked' => ! $liked,
            ]);
        }

        return back()->with('success', $message);
    }
}
