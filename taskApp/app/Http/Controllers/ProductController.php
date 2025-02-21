<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\ElasticsearchService;
use Exception;


class ProductController extends Controller
{
    protected $productService;
    protected $elasticsearchService;
    /**
     * Display a listing of the resource.
     */
    public function __construct(ProductService $productService, ElasticsearchService $elasticsearchService)
    {
        $this->productService = $productService;
        $this->elasticsearchService = $elasticsearchService;
    
    }

    public function index($id)
    {
        
        try {
            $products = $this->productService->index($id);
            return response()->json($products,200);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,99.99',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = $this->productService->store($data);

        return response()->json($product,201);
    }
    catch(Exception $e){
        return response()->json([
            'message' => 'Failed while stroring:',
            'error' => $e->getmessage(),
        ]);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->productService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,99.99',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $updatedProduct = $this->productService->update($data,$id);

        return response()->json($updatedProduct,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->destroy($id);
        return response()->noContent();
    }

    public function search(Request $request)
{
    try{
        $query = $request->input('query');

        $products = $this->elasticsearchService->searchProducts($query);
    
        return response()->json($products, 200);
    }
    catch(Exception $e){
        return response()->json([
            'message' => 'Failed while searching',
            'error' => $e->getmessage(),
        ]);
    }
    
}
}
