<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string', // e.g. like, love, etc.
        ]);

        $reaction = Reaction::updateOrCreate(
            [
                'post_id' => $data['post_id'],
                'user_id' => $data['user_id'],
            ],
            ['type' => $data['type']]
        );

        return response()->json($reaction, 201);
    }

    public function destroy(Reaction $reaction)
    {
        $reaction->delete();

        return response()->json(null, 204);
    }
}
