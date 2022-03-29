<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'genre' => 'required|string',
            'price' => 'required',
        ]);
        Book::query()->create($validate);
        return response()->json([]);
    }

    public function show()
    {
        $books = Book::all()->where('reserved',false);
        return response()->json($books);
    }

    public function delete(Book $id)
    {
        $id->delete();
        return response()->json([]);
    }
}
