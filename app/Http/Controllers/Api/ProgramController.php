<?php

namespace App\Http\Controllers\Api;

use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        $programs =Program::all();
        return response()->json(['message' => "Program is retrieved successfully", 'programs'=>$programs]);
    }

    public function store(Request $request)
    {
        $program =Program::create(['name' =>  $request->input('name')]);
        return response()->json(['message' => "Program is created successfully", 'program'=>$program]);
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        $program->delete();

        return response()->json(['message' => "Program is deleted successfully"]);
    }
}
