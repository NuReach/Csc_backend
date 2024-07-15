<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request) 
    {
        $reply = new Reply([
            'content' => $request->content,
            'cmt_id' => $request->cmt_id,
            'user_id' => Auth::id(),
        ]);

        $reply->save();

        return response()->json(['message' => 'Reply created successfully', 'data' => $reply], 201); 
    }
    public function destroy($replyId)
    {
        $reply = Reply::findOrFail($replyId);

        if ($reply->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403); 
        }

        $reply->delete();

        return response()->json(['message'=>'Reply is deleted'], 201); 
    }
}
