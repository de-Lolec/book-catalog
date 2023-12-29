<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Actions\SaveImageAction;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');

        $books = Book::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with('author')->paginate(10);
    
        return $books;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SaveImageAction $saveImageAction)
    {
        $path = $saveImageAction($request);

        $book = Book::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'year' => $request['year'],
            'image' => $path,
        ]);

        if($request['categories']){
            $categories = explode(',', $request['categories']);
            foreach($categories as $category_id){
                BookCategory::create([
                    'book_id' => $book->id,
                    'category_id' => $category_id
                ]);
            }
        }

        return response()->json(['message' => "Книга успешно сохранена"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
