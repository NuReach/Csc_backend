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

        return response()->json($users, 200);;
    }

    public function userPagination ( Request $request , $search , $sortBy , $sortDir ) {
        $page = 15;
        if ($search == "all") {
            $users = User::
              orderBy($sortBy, $sortDir)
            ->paginate($page);
        }else{
            $users = User::
             where('name',"LIKE","%$search%")
            ->orWhere('email',"LIKE","%$search%")
            ->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }
        return response()->json($users, 200);
    }

    public function getUserById ($id) {

        $user = User::findorFail($id);

        return response()->json($user, 200);
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
        ]);
        return response()->json(['user'=>$user,'message'=>'User is created successfully.'], 200);
    }

    public function updateUser (Request $request , $id) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'role' => 'required'
        ]);
        

        $user = User::find($id);

        if (!$user) {

            return response()->json(['message'=>'User is not found'], 404);
        }


        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->update($request->except('password'));

        return response()->json(['user'=>$user,'message'=>'User is updated successfully'], 200);
    }
}

