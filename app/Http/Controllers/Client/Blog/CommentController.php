<?php

namespace App\Http\Controllers\Client\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\ReplyCommentRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $post->comments()->create($request->validated());

        return back()->with('success', __('comment.messages.create_success'));
    }

    public function update(Comment $comment, UpdateCommentRequest $request): JsonResponse|RedirectResponse
    {
        $comment->update($request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => $comment->wasChanged(),
                'content' => $comment->content,
                'commentId' => $comment->id,
            ]);
        }

        return back()->with('success', __('comment.messages.update_success'));
    }

    public function destroy(Request $request, Comment $comment): JsonResponse|RedirectResponse
    {
        $comment->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'commentId' => $comment->id]);
        }

        return back()->with('success', 'Comment deleted');
    }

    public function reply(ReplyCommentRequest $request, Comment $comment): JsonResponse|RedirectResponse
    {
        // $request->validate([
        //     'content' => 'required|string|max:1000',
        // ]);
        // $data = [
        //     'user_id' => auth()->id(),
        //     'post_id' => $comment->post_id,
        //     'parent_id' => $comment->id,
        //     'content' => $request->content,
        // ];
        $reply = $comment->replies()->create($request->validated());

        if ($request->ajax()) {
            $replyHtml = view('components.blogs.comment', ['comment' => $reply])->render();

            return response()->json([
                'success' => true,
                'replyHtml' => $replyHtml,
                'parentId' => $comment->id,
            ]);
        }

        return back()->with('success', __('comment.messages.reply_success'));
    }
}
