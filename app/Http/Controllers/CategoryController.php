<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Undocumented variable
     *
     * @var object
     */
    protected $repository;

    /**
     * Undocumented function
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->repository = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->repository->get();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateCategory $request
     * @return void
     */
    public function store(StoreUpdateCategory $request)
    {

        $data = $request->validated();
        $data['url'] = Str::slug($data['title'], '-');
        $category = $this->repository->create($data);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCategory $request, $url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();
        $data = $request->validated();
        $data['url'] = Str::slug($data['title'], '-');
        $category->update($data);
        return response()->json(['message' => 'sucess']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();
        $category->delete();
        return response()->json([], 204);
    }
}
