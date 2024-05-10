<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use App\Models\Course;
use App\Models\Country;
use App\Models\Program;
use App\Models\Service;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getAllUsers(){
        try {
            $user = User::all();
            return response()->json(['users'=>$user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve user size.'], 500);
        }     
    }
    public function dashboard() {
        $posts = Post::all();
        $countries = Country::all();
        $users = User::all();
        $languages = Language::all();
        $courses = Course::all();
        $programs = Program::all();
        $videos = Video::all();
        $services = Service::all();
        
        return response()->json([
            'posts' => $posts,
            'countries' => $countries,
            'users' => $users,
            'languages' => $languages,
            'courses' => $courses,
            'programs' => $programs,
            'videos' => $videos,
            'services' => $services,
        ]);
    }
    
    
}
