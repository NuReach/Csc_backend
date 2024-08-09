<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
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
    
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function updateisLogged ( $user_id ){
        $user = User::find($user_id);
        $user->isLogged = false;
        $user->save();
        // $user->tokens()->delete();
        return response()->json(['message' => 'User Successfully logged out']);
    }
}


