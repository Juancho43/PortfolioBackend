<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $Proyect = Tags::all();

        return response()->json([
            'Proyect' => $Proyect
        ]);
    }

    public function show($id)
    {
        $Tags = Tags::find($id);

        return response()->json([
            'Tags' => $Tags
        ]);
    }

    public function store(Request $request)
    {
        $Tags = new Tags;

        $Tags->name = $request->input('name');
   
        
        $Tags->save();

        return response()->json([
            'message' => 'Tag created successfully',
            'Tags' => $Tags
        ]);
    }

    public function update(Request $request, $id)
    {
        $Tags = Tags::find($id);
        
        $Tags->name = $request->input('name');
        
        $Tags->save();

        return response()->json([
            'message' => 'Tag edited successfully',
            'Tags' => $Tags
        ]);
    }

    public function destroy($id)
    {
        $Tags = Tags::find($id);

        $Tags->delete();

        return response()->json([
            'message' => 'Tag deleted successfully'
        ]);
    }
}
