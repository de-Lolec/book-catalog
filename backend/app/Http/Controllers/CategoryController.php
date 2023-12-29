<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category([
            'title' => $request['title'],
            'description' => $request['description'],
        ]);

        $category->save();

        return response()->json(['message' => 'Категория успешно сохранена'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    { 
        $category = Category::find($id);

        $category->update($request->all());

        return response()->json(['message' => 'Категория успешно обновлена', 'data' => $category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);

        return response()->json(['message' => 'Категория успешно удалена'], 200);
    }
}
