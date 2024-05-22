<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function getAllCourses () 
        {
            $courses = Course::with('user')->get();
            return response()->json($courses, 200);
        }
    public function getCourseById ($id) 
        {
            $course = Course::findOrFail($id);
            return response()->json($course, 200);
        }

    public function getCoursesPagination ( Request $request , $search , $sortBy , $sortDir){
        $page = 6;
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

    public function deleteCourse($id)
        {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json(["message" => "Course Deleted Successfully"], 200);
        }

    public function createCourse (Request $request)
        {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'desc' => 'required|string',
                'image' => 'required|string',
                'price' => 'required|integer',
                'cost' => 'required|integer',
                'discount' => 'required|integer',
                'duration' => 'required|string',
                'user_id' => 'required|exists:users,id', // Assuming you have a 'users' table
                'type' => 'required|string',
            ]);
            $course = new Course();
            $course->title = $validatedData['title'];
            $course->desc = $validatedData['desc'];
            $course->image = $validatedData['image'];
            $course->price = $validatedData['price'];
            $course->cost = $validatedData['cost'];
            $course->discount = $validatedData['discount'];
            $course->duration = $validatedData['duration'];
            $course->user_id = $validatedData['user_id'];
            $course->type = $validatedData['type'];
            $course->save();
            return response()->json(["message"=>"Course Created Successfully", "course"=>$course], 200);
        }
    public function updateCourse(Request $request, $id)
        {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'desc' => 'required|string',
                'image' => 'nullable|string', // Allow empty image update
                'price' => 'required|integer',
                'cost' => 'required|integer',
                'discount' => 'required|integer',
                'duration' => 'required|string',
                'type' => 'required|string',
            ]);
        
            // Find the course by ID
            $course = Course::findOrFail($id);
        
            // Update course attributes with validated data
            $course->update($validatedData);
        
            return response()->json(["message" => "Course Updated Successfully", "course" => $course], 200);
        }

    public function addUserToCourse ( $user_id , $course_id ) {

        $course = Course::findOrFail($course_id);
        $user = User::findOrFail($user_id);

        UserCourse::create([
            'user_id' => $user_id,
            'course_id' => $course_id
        ]);
        
        return response()->json(['message' => 'User added to course successfully'], 200);
    }

    public function getCourseBelongToUser ( $user_id ) {
        $coursesOfUser =  DB::table('user_courses as uc')
        ->join('courses as c', 'c.id', '=', 'uc.course_id')
        ->where('uc.user_id', $user_id)
        ->select('uc.id','uc.user_id', 'uc.course_id', 'c.title', 'c.image')
        ->get();
        return response()->json($coursesOfUser, 200);
    }

    public function deleteUserFromCourse ( $item_id) {
        $item = UserCourse::findOrFail($item_id);
        $item->delete();
        return response()->json(['message' => 'User leave course successfully'], 201);
    }
}
