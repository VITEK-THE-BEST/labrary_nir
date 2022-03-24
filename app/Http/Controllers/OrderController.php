<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Book $book)
    {
        $user = auth()->user();
        if ($book['reserved'] == false) {
            $user->books()->attach($book);
            return response()->json([]);
        }
        return response()->json(['error' => "книга уже зарезирвирована"]);
    }



}
