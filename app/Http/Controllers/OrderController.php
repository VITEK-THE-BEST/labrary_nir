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
                'complete' => false
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
//        return $book;
//        $test = $book->orders()->take(-1)->get();
//        return $test;
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
        $books_dublicate = [];
        $books_helper = [];

        $orders = auth()->user()
            ->with('orders.book')
            ->get()[0]['orders'];

        //если это кто-то видит - прости, надо очень быстро решить задачу
        foreach ($orders as $order) {
            foreach ($books_helper as $book) {
                if ($order['book']['id'] == $book) {

                    array_push($books_dublicate, $book);
                }
            }
            array_push($books_helper, $order['book']['id']);
        }
        $books_dublicate = array_unique($books_dublicate);


        $orders = $orders
            ->filter(function ($value) {
                if ($value['book']['reserved'] == true) {
                    return true;
                }
                return false;
            });
        foreach ($orders as $key => $order) {
            foreach ($books_dublicate as $k => $book)
                if ($order['book']['id'] == $book) {
                    unset($orders[$key]);
                    unset($books_dublicate[$k]);
                }
        }


        return response()->json($orders);
    }

    public function getPrice(Request $request, Book $book)
    {

        $bookPrice = $book->price;
        $date = Carbon::parse($request['date']);
        $daysCompeteOrder = $date->diffInDays(Carbon::now());
        return response()->json([
            "order_price" => ($bookPrice / 2),
            "date_order_price" => $daysCompeteOrder * ($bookPrice * 0.05)
        ]);
    }

    public function getCompletePrice(Book $book)
    {
        $order = $book
            ->with('orders')
            ->get()
            ->filter(function ($value) use ($book) {
                if ($value['id'] == $book['id']) {
                    foreach ($value['orders'] as $order) {
                        if ($order['complete'] == false) {
                            return true;
                        }
                    }
                }
                return false;
            })
            ->flatten();
        $bonus = 0;
        $created_at = Carbon::parse($order[0]['orders'][0]['created_at']);
        $date_complete_order = Carbon::parse($order[0]['orders'][0]['date_complete_order']);
//        $test = Carbon::parse("2023-01-01");
//        if (Carbon::now()->gt($date_complete_order)) {
        if (Carbon::now()->gt($date_complete_order)) {
            $bonus = Carbon::now()->diffInDays($date_complete_order) * ($order[0]['price'] * 0.1); // цена за неуплаченные дни
        }

        $daysCompeteOrder = $created_at->diffInDays($date_complete_order) * ($order[0]['price'] * 0.05);//цена за дни улпаченные
        //если число отрицательное, значит что пользователь должен дать денег
        $price = ($order[0]['price'] / 2) - ($daysCompeteOrder + $bonus);

        return response()->json($price);
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
