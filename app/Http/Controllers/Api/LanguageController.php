<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{

    public function store(Request $request)
    {
        $language =Language::create(['name' =>  $request->input('name')]);
        return response()->json(['message' => "Language is created successfully", 'language'=>$language]);
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);

        $language->delete();

        
        return response()->json(['message' => "Language is deleted successfully"]);
    }
}
