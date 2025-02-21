<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use Exception;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        return $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->index();
        try {
            return response()->json($categories,200);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
           'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = $this->categoryService->store($data);

        return response()->json($category,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->categoryService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $updatedCategory = $this->categoryService->update($data,$id);

        return response()->json($updatedCategory,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->destroy($id);
        return response()->noContent();
    }
}
