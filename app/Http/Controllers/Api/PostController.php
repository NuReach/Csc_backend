<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function getPosts (){
        $posts = Post::all();
        return response()->json(['posts'=>$posts,'message'=>'All posts'], 200);
    }

    public function getOnePost ($id){

        $post = Post::findorFail($id);

        return response()->json(['post'=>$post,'message'=>'Your post '], 200);
    }

    public function createPost (Request $request) {

        $validatedData = $request->validate([
            'title' => 'required|string',
            'country' => 'required|string',
            'status' => 'required|string',
            'deadline' => 'required|date',
            'shortDescription' => 'required|string',
            'imgLink' => 'required|string|url',
            'author' => 'required|string',
            'program' => 'required|string',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);
        
        $post = Post::create($validatedData);

        return response()->json(['post'=>$post,'message'=>'Your data is created successfully'], 200);
    }

    public function updatePost (Request $request, $id){

        $validatedData = $request->validate([
            'title' => 'required|string',
            'country' => 'required|string',
            'status' => 'required|string',
            'deadline' => 'required|date',
            'shortDescription' => 'required|string',
            'imgLink' => 'required|string|url',
            'author' => 'required|string',
            'program' => 'required|string',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::find($id);

        if (!$post) {

            return response()->json(['message'=>'Your data is not found'], 404);
        }

        $post->update($validatedData);

        return response()->json(['updatedPost'=>$post,'message'=>'Your data is updated successfully'], 200);
    }

    public function deletePost (Request $request,$id){

        $post = Post::find($id);

        if (!$post) {
            
            return response()->json(['message'=>'Your data is not found'], 404);
        }

        $post->delete();

        return response()->json(['message'=>"Item with id : $id is deleted "], 200);
    }
}
