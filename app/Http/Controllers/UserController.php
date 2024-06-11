<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'results' => $users
        ], 200);
    }

    public function store(UserStoreRequest $request)
    {
        try {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json([
                'message' => "User added successfully!"
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => "Something went wrong!"
            ], 500);
        }

    }

    public function show($id)
    {
        $users = User::find($id);

        if(!$users) {

            return response()->json([
                'message' => 'User not found'
            ], 400);
        }

        return response()->json ([
            'users' => $users
        ], 200);
    }

    public function update(UserStoreRequest $request, $id)
    {
        try {

            $users = User::find($id);
            if(!$users){
                return response()->json([
                    'message' => 'User Not Found.'
                ], 404);
            }

            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = $request->password;

            $users->save();

            return response()->json([
                'message' => 'User sucessfully updated.'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => "Something went wrong!"
            ], 500);
        }
    }

    public function destroy($id)
    {

        $users = User::find($id);

        if(!$users){

            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        $users->delete();

        return response()->json([
            'message' => "User sucessfully deleted."
        ], 200);
    }
}
