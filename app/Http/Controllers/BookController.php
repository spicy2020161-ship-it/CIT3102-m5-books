<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET: List all books and filter records
    public function index(Request $request)
    {
        $query = Book::query();

        foreach (['genre', 'shelf_location'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        return response()->json($query->get(), 200);
    }

    // POST: Create a new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'copies' => 'required|integer|min:0',
            'shelf_location' => 'required|string|max:255',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    // GET: View a specific book
    public function show(Book $book)
    {
        return response()->json($book, 200);
    }

    // PUT: Update an existing book
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|string|max:255',
            'copies' => 'sometimes|required|integer|min:0',
            'shelf_location' => 'sometimes|required|string|max:255',
        ]);

        $book->update($validated);

        return response()->json($book, 200);
    }

    // DELETE: Delete a book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
