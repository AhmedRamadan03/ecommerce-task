<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $categories = Category::get();
        return $this->successResponse(CategoryResource::collection($categories));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);
       return $this->successResponse(new CategoryResource($category));
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return $this->successResponse(new CategoryResource($category));

    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();
        $category->update($data);
        return $this->successResponse(new CategoryResource($category));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->successResponse([],'Category deleted');
    }
}
