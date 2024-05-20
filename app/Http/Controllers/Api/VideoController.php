<?php

namespace App\Http\Controllers\API;

use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function getAllVideos()
    {
        $videos = Video::with('user')->get();
        return response()->json(['message' => 'Successfully retrieved videos', 'data' => $videos]);
    }

    public function getVideoByID($id)
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        return response()->json(['message' => 'Video retrieved successfully', 'data' => $video]);
    }

    public function createVideo(Request $request)
    {
        $validatedData = $request->validate([
            'v_title' => 'required|string',
            'v_duration' => 'required|integer',
            'v_link' => 'required|string',
            'v_description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $video = Video::create($validatedData);

        return response()->json(['message' => 'Video created successfully', 'data' => $video], 201);
    }
    public function updateVideo(Request $request, $id)
    {
        $validatedData = $request->validate([
            'v_title' => 'required|string',
            'v_duration' => 'required|integer',
            'v_link' => 'required|string',
            'v_description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $video->update($validatedData);

        return response()->json(['message' => 'Video updated successfully', 'data' => $video], 200);
    }
    public function deleteVideo($id)
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $video->delete();
        return response()->json(['message' => 'Video deleted successfully'], 204);
    }

    public function getVideoBelongToCourse ($course_id) {
        $course = Course::find($course_id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        $videos = video::where('course_id',$course_id)->get();
          return response()->json($videos,200);
    }
}
