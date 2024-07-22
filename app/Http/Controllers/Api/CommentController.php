<?php

namespace App\Http\Controllers\api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index () {
        $comments = Comment::limit(8)
        ->paginate();
        return response()->json($comments, 200);
    }

    public function store(Request $request)
    {
        $comment = new Comment([
            'content' => $request->content,
            'video_id' => $request->video_id,
            'user_id' => Auth::id(),
        ]);

        $comment->save();

        return response()->json(['message' => 'Comment created successfully', 'data' => $comment], 201); 
    }

    public function update(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403); 
        }

        $comment->update($request->only('content'));

        return response()->json(['message'=>'Updated Succesfully'], 204);
    }
    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // if ($comment->user_id !== Auth::id() ) {
        //     return response()->json(['error' => 'Unauthorized'], 403); 
        // }

        $comment->delete();

        return response()->json(['message'=>'Comment is deleted'], 201); 
    }
}
