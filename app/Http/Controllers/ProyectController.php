<?php

namespace App\Http\Controllers;

use App\Models\Proyect;
use Illuminate\Http\Request;

class ProyectController extends Controller
{
    public function index()
    {
        $Proyect = Proyect::with('tags')->get();

        return response()->json([
            'Proyect' => $Proyect
        ]);
    }

    public function show($id)
    {
        $Proyect = Proyect::with('tags')->find($id);

        return response()->json([
            'Proyect' => $Proyect
        ]);
    }

    public function store(Request $request)
    {
        $Proyect = new Proyect;

        $Proyect->name = $request->input('name');
        $Proyect->description = $request->input('description');
        
        $Proyect->save();

   // Retrieve the tags from the request
        $tags = $request->input('tags'); 

        // Attach the tags to the project
        if ($tags) {
            $Proyect->tags()->sync($tags); 
        }


        return response()->json([
            'message' => 'Proyect created successfully',
            'Proyect' => $Proyect
        ]);
    }

    public function update(Request $request, $id)
    {
        $Proyect = Proyect::with('tags:id,name')->find($id);
        
        $Proyect->name = $request->input('name');
        $Proyect->description = $request->input('description');
        
        $Proyect->save();

        return response()->json([
            'message' => 'Proyect created successfully',
            'Proyect' => $Proyect
        ]);
    }

    public function destroy($id)
    {
        $task = Proyect::find($id);

        $task->delete();

        return response()->json([
            'message' => 'Proyect deleted successfully'
        ]);
    }
}
