<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\User;
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

    public function createAdmin(Request $request, Book $book)
    {
        $validate = $request->validate([
            'date_complete_order' => 'required',
            'user_id' => 'required',
        ]);


        $user = User::query()->findOrFail($validate['user_id']);
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
    public function completeAdmin(Book $book, User $user)
    {
        $book->reserved = false;
        $book->save();

        $books = $book
            ->orders()
            ->get()
            ->where('user_id', $user->id);

        $order = $books->filter(function ($value) {
            $updated_at = Carbon::parse($value['updated_at']);
            $date_complete_order = Carbon::parse($value['date_complete_order']);
            return $date_complete_order->ne($updated_at);
        });
        $order = $order->first();
        $order->updated_at = Carbon::now();
        $order->save();
        return response()->json([]);
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

    public function showAllCompleteOrder()
    {
        return Order::query()
            ->with('book')
            ->get()
            ->filter(function ($value) {
                $created_at = Carbon::parse($value['created_at']);
                $updated_at = Carbon::parse($value['updated_at']);
                return $created_at->ne($updated_at);
            })
            ->map(function ($value) {
                return $this->getPriceFromOrder($value);
            });
    }

    public function showAllNotCompleteOrder()
    {
        return Order::query()
            ->with([
                'book',
                'user'
            ])
            ->get()
            ->filter(function ($value) {
                $created_at = Carbon::parse($value['created_at']);
                $updated_at = Carbon::parse($value['updated_at']);
                return $created_at->eq($updated_at);
            })
            ->map(function ($value) {
                $date_complete_order = Carbon::parse($value['date_complete_order']);
                $value['status'] = $date_complete_order->gt(Carbon::now()) ? "ожидает возращения" : "не вернул в срок";

                return $this->getPriceFromOrder($value);
            });
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

        $filtered = $orders['orders']->filter(function ($value) {
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

        $filtered = $orders['orders']->filter(function ($value) {
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
        return response()->json(($bookPrice / 2) /*+ ($daysCompeteOrder * ($bookPrice * 0.05))*/);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getPriceFromOrder($value)
    {
        $created_at = Carbon::parse($value['created_at']);
        $updated_at = Carbon::parse($value['updated_at']);

        $bonus = 0;
        $date_complete_order = Carbon::parse($value['date_complete_order']);

        if ($date_complete_order->gt($updated_at)) {
            $bonus = $date_complete_order->diffInDays($updated_at) * ($value['book']['price'] * 0.1); // цена за неуплаченные дни
        }

        $daysCompeteOrder = $created_at->diffInDays($date_complete_order) * ($value['book']['price'] * 0.05);//цена за дни улпаченные

        //если число отрицательное, значит что пользователь должен дать денег
        $value['price'] = ($value['book']['price'] / 2) - ($daysCompeteOrder + $bonus);

        return $value;
    }


}
