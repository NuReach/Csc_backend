<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers () {

        $users = User::all();

        return response()->json(['users'=>$users], 200);;
    }

    public function getUserById () {

        $post = User::findorFail($id);

        return response()->json(['user'=>$user,'message'=>'Your post '], 200);
    }

        public function deleteUser (Request $request,$id){

        $user = User::find($id);

        if (!$user) {
            
            return response()->json(['message'=>'User is not found'], 404);
        }

        $user->delete();

        return response()->json(['message'=>"User with id : $id is deleted "], 200);
    }

    public function createUser (Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => 'user', 
            'status' => 'active',
        ]);
        return response()->json(['user'=>$user], 200);
    }

    public function updateUser (Request $request , $id) {

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'email' => 'required|email',
            'role' => 'required'
        ]);
        

        $user = User::find($id);

        if (!$user) {

            return response()->json(['message'=>'User is not found'], 404);
        }

        
        $user->update($request->all());

        return response()->json(['user'=>$user,'message'=>'User is updated successfully'], 200);
    }
}

