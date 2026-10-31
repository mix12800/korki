<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
        $user = User::create($request->all());
        return response()->json(['user' => $user, 'token' => $user->createToken('api_token')->plainTextToken]);
    }

    public function auth(AuthRequest $request)
    {
        $user = User::where('login', $request->login)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json(['user' => $user, 'token' => $user->createToken('api_token')->plainTextToken]);
        }
        return response()->json(['errors' => ['login' => ['ошибка входа']]]);
    }
}
