<?php

namespace App\Http\Controllers\V1;


use App\Repository\V1\EducationRepository;
use App\Http\Requests\V1\EducationRequest;
use App\Http\Resources\V1\EducationResourceColletion;
use App\Http\Resources\V1\EducationResource;

class EducationController extends Controller
{


    protected $EducationRepository;


    public function __construct(EducationRepository $EducationRepository, )
    {
        $this->EducationRepository = $EducationRepository;

    }


    public function index()
    {
        return new EducationResourceColletion($this->EducationRepository->all());
    }

    public function show($id)
    {
        return new EducationResource($this->EducationRepository->find($id));
    }

    public function AllEducation($id){

        $data = $this->EducationRepository->findWithProjects($id);
        return response()->json([
            'Data' => $data
        ]);
    }

    public function showByType($type){
        return new EducationResourceColletion( $this->EducationRepository->whereType($type));

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
