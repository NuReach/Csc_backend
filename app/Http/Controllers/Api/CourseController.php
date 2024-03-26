<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getAllCourses () {
        return response()->json("get all course", 200);
    }
    public function getCourseById ($id) {
        return response()->json("get cours", 200);
    }
    public function deleteCourse ($id) {
        return response()->json("delete course", 200);
    }
    public function createCourse (Request $request ,$id){
        return response()->json("create course", 200);

    }
    public function updateCourse (Request $request , $id){
        return response()->json("update course", 200);
    }
}
