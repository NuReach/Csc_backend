<?php

namespace App\Http\Controllers\api;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoResoucreController extends Controller
{
    public function index()
    {
        return Resource::all();
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required|string|url',
            'video_id' => 'required|integer|exists:videos,id', // Ensure video exists
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $resource = Resource::create($request->all());

        return response()->json($resource, 201);
    }
    public function show($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return $resource;
    }
    public function update(Request $request, $id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'link' => 'required|string|url',
            'video_id' => 'required|integer|exists:videos,id', // Ensure video exists
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $resource->update($request->all());

        return response()->json($resource, 200);
    }
    public function destroy($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $resource->delete();

        return response()->json(['message' => 'Resource deleted successfully'], 204);
    }

}
