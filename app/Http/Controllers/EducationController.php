<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::orderBy('endDate', 'asc')->get();

        return response()->json([
            'education' => $education
        ]);
    }

    public function show($id)
    {
        $education = Education::where('id', $id)
        ->first();

        return response()->json([
            'education' => $education
        ]);
    }

    public function AllEducation($id){
        
        return response()->json([
            'Data' => Education::with('proyect')->find($id)
        ]);
    }

    public function showByType($type){
        $education = Education::where('type',$type)->orderBy('endDate', 'asc')->get();
        return response()->json([
            'education' => $education
        ]);

    }

    public function store(Request $request)
    {
        $education = new Education;

        $education->name = $request->input('name');
        $education->description = $request->input('description');
        $education->startDate = $request->input('startDate');
        $education->endDate = $request->input('endDate');
        $education->type = $request->input('type');
        $education->profile_id = $request->input('profile_id');
        $education->save();

        return response()->json([
            'message' => 'Education created successfully',
            'education' => $education
        ]);
    }

    public function update(Request $request, $id)
    {
        $education = Education::find($id);

        $education->name = $request->input('name');
        $education->description = $request->input('description');
        $education->startDate = $request->input('startDate');
        $education->endDate = $request->input('endDate');
        $education->type = $request->input('type');
        $education->save();

        return response()->json([
            'message' => 'Education created successfully',
            'education' => $education
        ]);
    }

    public function destroy($id)
    {
        $task = Education::find($id);

        $task->delete();

        return response()->json([
            'message' => 'Education deleted successfully'
        ]);
    }
}
