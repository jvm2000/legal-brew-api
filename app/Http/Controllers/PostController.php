<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = \App\Models\Post::with(['user', 'comments', 'reactions'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $form = $request->validate([
            'description' => 'string',
            'hyperlink' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'string',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $imagePaths[] = $path;
            }
        } 

        $form['images'] = $imagePaths;

        $post = Post::create($form);

        return response()->json($post, 201);
    }

    // Update post 
    public function update(Request $request, Post $post)
    {
        $form = $request->validate([
            'description' => 'string',
            'hyperlink' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'string',
        ]);

        $imagePaths = $post->images ?? [];

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $imagePaths[] = $path;
            }
        }

        $form['images'] = $imagePaths;

        $post->update($form);

        return response()->json($post, 200);
    }
    
    // Delete a post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Optional: delete images from storage
        if ($post->images) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }

}
