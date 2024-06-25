<?php

namespace App\Http\Controllers\api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function index () {
        $comments = Comment::limit(8)
        ->paginate();
        return response()->json($comments, 200);
    }

    public function store(StoreCommentRequest $request, $videoId)
    {
        $comment = new Comment([
            'content' => $request->content,
            'video_id' => $videoId,
            'user_id' => Auth::id(),
        ]);

        $comment->save();

        return Response::json($comment, 201); // Created status code
    }

    public function update(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Check authorization (ensure user can only edit their own comments)
        if ($comment->user_id !== Auth::id()) {
            return Response::json(['error' => 'Unauthorized'], 403); // Forbidden status code
        }

        $comment->update($request->only('content'));

        return Response::json($comment, 200); // OK status code
    }
    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Check authorization (ensure user can only delete their own comments)
        if ($comment->user_id !== Auth::id()) {
            return Response::json(['error' => 'Unauthorized'], 403); // Forbidden status code
        }

        $comment->delete();

        return Response::json(null, 204); // No Content status code
    }
}
