<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\TagRequest;
use App\Http\Resources\V1\TagResource;
use App\Http\Resources\V1\TagResourceCollection;
use App\Repository\V1\TagRepository;
use Exception;

class TagsController extends Controller
{
    use ApiResponseTrait;
    protected $repository;


    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;

    }

    public function index()
    {

        try{
            return $this->successResponse(new TagResourceCollection($this->repository->all()));
        }catch(Exception $e){
            return $this->errorResponse("Error al obtener los datos de tags",$e->getMessage(),500);
        }


    }

    public function show($id)
    {
       return new TagResource($this->repository->find($id));
    }

    public function store(TagRequest $request)
    {
        return new TagResource($this->repository->create($request->validated()));
    }

    public function update(TagRequest $request, $id)
    {
        return new TagResource($this->repository->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);

        return response()->json([
            'message' => 'Tag deleted successfully'
        ]);
    }
}
