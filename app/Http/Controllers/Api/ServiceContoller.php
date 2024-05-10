<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceContoller extends Controller
{
    public function store(Request $request)
    {
        $service =Service::create(['name' =>  $request->input('name')]);
        return response()->json(['message' => "Service is created successfully", 'service'=>$service]);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $service->delete();

        return response()->json(['message' => "Service is deleted successfully"]);
    }
}
