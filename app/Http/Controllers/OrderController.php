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
            $book->reserved = true;
            $book->save();
            return response()->json([]);
        }
        return response()->json(['error' => "книга уже зарезирвирована"], 403);
    }

    /**
     *
     * @response 404 данная книга уже сданна
     * */
    public function complete(Book $book)
    {
        $book = auth()->user()
            ->books()
            ->where('reserved', true)
            ->findOrFail($book->id);

        $book->reserved = false;
        $book->save();
        return response()->json([]);
    }


}
