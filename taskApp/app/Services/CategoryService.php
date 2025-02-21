<?php

namespace App\Services;
use App\Models\Category;
use Exception;

class CategoryService
{
    public function index(){
        return Category::all();
    }

    public function store($data){
        return Category::create($data);
    }

    public function show($id){
        $category = Category::findOrFail($id);
        return $category;
    }

    public function update($data, $id){
        $category = Category::find($id);
        $category->update($data);
        return $category;
    }

    public function destroy($id){
        return Category::destroy($id);
    }
}
