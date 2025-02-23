<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\TagResourceCollection;
use App\Repository\TagRepository;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    protected $repository;


    public function __construct(TagRepository $repository, )
    {
        $this->repository = $repository;

    }

    public function index()
    {
        return new TagResourceCollection($this->repository->all());
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
