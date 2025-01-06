<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $Profile = User::with("profile")->get();

        return response()->json([
            'Profile' => $Profile
        ]);
    }

    public function show($id)
    {
        // $Profile = Profile::find($id);
        $Profile = User::with("profile")->find($id);
        return response()->json([
            'Profile' => $Profile
        ]);
    }

    public function store(Request $request)
    {
        $Profile = new Profile;

        $Profile->rol = $request->input('rol');
        $Profile->description = $request->input('description');
        $Profile->github = $request->input('github');
        $Profile->linkedin = $request->input('linkedin');
        $Profile->publicMail = $request->input('publicMail');
        
        $Profile->save();

        return response()->json([
            'message' => 'Profile created successfully',
            'Profile' => $Profile
        ]);
    }

    public function update(Request $request, $id)
    {
        $Profile = Profile::find($id);

        $Profile->rol = $request->input('rol');
        $Profile->description = $request->input('description');
        $Profile->github = $request->input('github');
        $Profile->linkedin = $request->input('linkedin');
        $Profile->publicMail = $request->input('publicMail');
        $Profile->save();

        return response()->json([
            'message' => 'Profile edited successfully',
            'Profile' => $Profile
        ]);
    }

    public function destroy($id)
    {
        $task = Profile::find($id);

        $task->delete();

        return response()->json([
            'message' => 'Profile deleted successfully'
        ]);
    }
}
