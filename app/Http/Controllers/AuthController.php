<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //REGISTER
    public function register(Request $request)
    {
        $fields = $request -> validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);
        $user = User::create ([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => 'user'
        ]);

        $token = $user -> createToken('tokenUser')->plainTextToken;

        $response = [
            'message' => 'Berhasil Register! Selamat datang di toko kami!',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    //LOGIN
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Gagal Login! Cek username atau password anda!'
            ], 401);
        }

        $token = $user->createToken('tokenUser')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    //LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Berhasil Logout'
        ];
    }
}
