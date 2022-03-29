<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function create(Request $request, Book $book)
    {
        $validate = $request->validate([
            'date_complete_order' => 'required',
        ]);


        $user = auth()->user();
        if ($book['reserved'] == false) {
            $user->books()->attach($book, [
                'date_complete_order' => $validate['date_complete_order'],

            ]);
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

    public function showCompleteOrder()
    {
        $orders = auth()->user()
            ->with([
                    'orders.book' => function ($query) {
                        $query->where("reserved", false);
                    }
                ]
            )
            ->get()[0];

        $filtered  = $orders['orders']->filter(function ($value){
            return $value['book'] != null;
        });

        $orders->toArray();
        unset($orders['orders']);
        $orders['orders'] = $filtered;

        return response()->json($orders);
    }

    public function showNotCompleteOrder()
    {
        $orders = auth()->user()
            ->with([
                    'orders.book' => function ($query) {
                        $query->where("reserved", true);
                    }
                ]
            )
            ->get()[0];

        $filtered  = $orders['orders']->filter(function ($value){
            return $value['book'] != null;
        });

        $orders->toArray();
        unset($orders['orders']);
        $orders['orders'] = $filtered;

        return response()->json($orders);
    }

    public function getPrice(Request $request, Book $book)
    {
        $bookPrice = $book->price;
        $date = Carbon::parse($request['date']);
        $daysCompeteOrder = $date->diffInDays(Carbon::now());
        return response()->json(($bookPrice / 2) + ($daysCompeteOrder * ($bookPrice * 0.005)));
    }
}
