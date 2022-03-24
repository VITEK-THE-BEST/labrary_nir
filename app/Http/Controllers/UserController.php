<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'patronymic' => 'sometimes',
            'address' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);

        $validate['password'] = Hash::make($validate['password']);

        $user = User::query()->create($validate);
        $token = $user->createToken($request['phone'])->plainTextToken;

        return response()->json(["user" => $user, "token" => $token]);

    }

    public function getToken(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::query()
            ->where('phone', $request['phone'])
            ->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json(["success" => false,
                "error" => "Неверный логин или пароль"], 404);
        }

        $token = $user->createToken($request['phone'])->plainTextToken;

        return response()->json(["token" => $token]);
    }


    public function me()
    {
        $user = auth()->user()->toArray();

        return response()->json(["user" => $user]);
    }


    public function dropToken()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([]);
    }

    public function delete($id)
    {
        $user = User::query()->find($id);
        $user->delete();
        return response()->json([]);
    }
}
