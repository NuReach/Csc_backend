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
        return response()->json($posts, 200);
    }

    public function getPostsNotIn($id) {
        $posts = Post::whereNotIn('id', [$id])->limit(19)->get();
        return response()->json($posts, 200);
    }

    public function getOnePost ($id){

        $post = Post::findorFail($id);

        return response()->json($post, 200);
    }

    public function getPostPagination ( Request $request , $search , $sortBy , $sortDir ){
        $page = 15;
        if ($search == "all") {
            $posts = Post::with('user')->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }else{
            $posts = Post::with('user')->where('title','LIKE',"%$search%")
            ->orWhere('shortDescription','LIKE',"%$search%")
            ->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }
        return response()->json($posts,200);
    }

    public function createPost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', // Limit title length to 255 characters for better database management
            'country' => 'required|string|max:255', // Limit country length to 255 characters
            'status' => 'required|string|max:255', // Limit status length to 255 characters
            'shortDescription' => 'required|string|max:255', // Limit short description length to 255 characters
            'deadline' => 'required|date_format:Y-m-d', // Ensure deadline format is YYYY-MM-DD for consistent storage
            'imgLink' => 'required|string|url',
            'program' => 'required|string|max:255', // Limit program length to 255 characters
            'category' => 'required|string|max:255', // Limit category length to 255 characters
            'content' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id', // Check if user_id exists in users table
        ]);
    
        // Optional: Handle potential validation errors gracefully (e.g., return appropriate HTTP response with error messages)
    
        $post = Post::create($validatedData);
    
        return response()->json([
            'post' => $post,
            'message' => 'Your data was created successfully.' // Use past tense for clarity
        ], 201); // Use 201 Created status code for successful creation
    }
    

    public function updatePost (Request $request, $id){

        $validatedData = $request->validate([
           'title' => 'required|string|max:255', // Limit title length to 255 characters for better database management
            'country' => 'required|string|max:255', // Limit country length to 255 characters
            'status' => 'required|string|max:255', // Limit status length to 255 characters
            'shortDescription' => 'required|string|max:255', // Limit short description length to 255 characters
            'deadline' => 'required|date_format:Y-m-d', // Ensure deadline format is YYYY-MM-DD for consistent storage
            'imgLink' => 'required|string|url',
            'program' => 'required|string|max:255', // Limit program length to 255 characters
            'category' => 'required|string|max:255', // Limit category length to 255 characters
            'content' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id', // Check if user_id exists in users table
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
