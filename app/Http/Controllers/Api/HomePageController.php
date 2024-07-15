<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\Video;
use App\Models\Course;
use App\Models\Country;
use App\Models\Program;
use App\Models\Service;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
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

    public function getPostsNotIn($id) {
        $posts = Post::whereNotIn('id', [$id])->limit(19)->get();
        return response()->json($posts, 200);
    }
    public function getOnePost ($id){

        $post = Post::findorFail($id);

        return response()->json($post, 200);
    }
    public function getCoursesPagination ( Request $request , $search , $sortBy , $sortDir){
        $page = 15;
        if ($search == "all") {
            $courses = Course::with('user')->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }else{
            $courses = Course::with('user')->where('title','LIKE',"%$search%")
            ->orWhere('desc','LIKE',"%$search%")
            ->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }
        return response()->json($courses,200);
    }
    public function getVideoBelongToCourse ($course_id) {
        $course = Course::find($course_id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        $videos = Video::where('course_id',$course_id)
                ->with('links')
                ->with('comments','comments.user','comments.replies','comments.replies.user')
                ->get();
          return response()->json($videos,200);
    }
    public function getCourseById ($id) 
    {
        $course = Course::findOrFail($id);
        return response()->json($course, 200);
    }   
    public function getCourseBelongToUser ( $user_id ) {
        $coursesOfUser =  DB::table('user_courses as uc')
        ->join('courses as c', 'c.id', '=', 'uc.course_id')
        ->where('uc.user_id', $user_id)
        ->select('uc.id','uc.user_id', 'uc.course_id', 'c.title', 'c.image')
        ->get();
        return response()->json($coursesOfUser, 200);
    }

    public function getSearchPost ( $destination , $program , $start , $until ){
        $posts = Post::where('country', $destination)
            ->where('program', $program)
            ->where('deadline', '>', $start)
            ->where('deadline', '<', $until)
            ->get();
            return response()->json($posts, 200);
    }
}
