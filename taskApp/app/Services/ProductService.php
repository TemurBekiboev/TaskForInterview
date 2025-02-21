<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;

class ProductService
{
    protected $elasticsearchService;

    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    public function index($id){
        $category = Category::findOrFail($id);
        $products = $category->products()->get();
        return $products;
    }

    public function store($data){
        $product = Product::create($data);

        $this->elasticsearchService->indexProduct($product);

        return $product;
    }

    public function show($id){
        $product = Product::findOrFail($id);
        return $product;
    }

    public function update($data, $id){
        $product = Product::find($id);
        $product->update($data);
        $this->elasticsearchService->indexProduct($product);
        return $product;
    }

    public function destroy($id){
        $product = Product::destroy($id);
        $this->elasticsearchService->deleteProduct($id);
        return $product;
    }
}
