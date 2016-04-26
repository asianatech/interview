<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $post = new Post();
        $post->author = $request->author;
        $post->title = $request->title;
        $post->content = $request->body;

        $post->save();

        return response()->json(['success' => 'post save']);
    }

    public function edit($id, Request $request)
    {
        $post = Post::find($id);

        if ($post == null) {
            return response()->json(['error' => 'post not found'], 404);
        }

        if ($post->author != $request->author) {
            return response()->json(['error' => 'unauthorized action'], 400);
        }

        $post->author = $request->author;
        $post->title = $request->title;
        $post->content = $request->body;
        $post->save();

        return response()->json(['success' => 'post updated']);
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if ($post == null) {
            return response()->json(['error' => 'post not found'], 404);
        }

        $post->delete();

        return response()->json(['success' => 'post has been deleted']);
    }
}
