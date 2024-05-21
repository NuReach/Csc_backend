<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\Country;
use App\Models\Program;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        $programs = Program::all();
        $posts = Post::where('category','scholarship')->orderBy('created_at','desc')->limit(4)->get();
        $flags = Country::where('status','popular')->limit(4)->get();
        $services = Service::all();
        
        return response()->json([
            'countries'=> $countries,
            'programs' => $programs,
            'posts' => $posts,
            'flags' => $flags,
            'services' => $services
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
