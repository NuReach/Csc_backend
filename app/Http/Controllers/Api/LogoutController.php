<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Revoke all tokens associated with the authenticated user
        $user = Auth::user();
        $user->isLogged = false;
        $user->save();
        $request->user()->tokens()->delete();
    
        return response()->json(['message' => 'Successfully logged out']);
    }
}
