<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
}
