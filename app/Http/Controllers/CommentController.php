<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = \App\Models\Comment::with('user')
            ->where('post_id', $post->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id', // Better validation
        ]);

        $comment = Comment::create($data);

        return response()->json([
            'message' => 'Comment created successfully.',
            'comment' => $comment->load('user'),
        ], 201);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
