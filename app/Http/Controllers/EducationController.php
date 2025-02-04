<?php

namespace App\Http\Controllers;


use App\Repository\EducationRepository;
use App\Http\Requests\EducationRequest;

class EducationController extends Controller
{


    protected $EducationRepository;


    public function __construct(EducationRepository $EducationRepository, )
    {
        $this->EducationRepository = $EducationRepository;
        
    }


    public function index()
    {
        $education = $this->EducationRepository->all();

        return response()->json([
            'education' => $education
        ]);
    }

    public function show($id)
    {
        $education = $this->EducationRepository->find($id);

        return response()->json([
            'education' => $education
        ]);
    }

    public function AllEducation($id){
        
        $data = $this->EducationRepository->findWithProjects($id);
        return response()->json([
            'Data' => $data
        ]);
    }

    public function showByType($type){
        $education = $this->EducationRepository->whereType($type);
        return response()->json([
            'education' => $education
        ]);

    }

    public function store(EducationRequest $request)
    {
        $education = $this->EducationRepository->create($request->validated());

        // $education->name = $request->input('name');
        // $education->description = $request->input('description');
        // $education->startDate = $request->input('startDate');
        // $education->endDate = $request->input('endDate');
        // $education->type = $request->input('type');
        // $education->profile_id = $request->input('profile_id');
        // $education->save();

        

        return response()->json([
            'message' => 'Education created successfully',
            'education' => $education
        ]);
    }

    public function update(EducationRequest $request, $id)
    {
        
        $education = $this->EducationRepository->update($id,$request->validated());

        // $education->name = $request->input('name');
        // $education->description = $request->input('description');
        // $education->startDate = $request->input('startDate');
        // $education->endDate = $request->input('endDate');
        // $education->type = $request->input('type');
        // $education->save();

        return response()->json([
            'message' => 'Education updated successfully',
            'education' => $education
        ]);
    }

    public function destroy($id)
    {
        $education = $this->EducationRepository->delete($id);

        return response()->json([
            'message' => 'Education deleted successfully'
        ]);
    }
}
