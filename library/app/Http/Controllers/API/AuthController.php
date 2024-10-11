<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Roles;

class AuthController extends Controller
{
    public function showLoginForm()
{
    return view('auth.login');
}
     public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $roleUser = Roles::where('nama', 'user')->first();

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser->id
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            "messege" => "Register Berhasil",
            "user" => $user,
            "token" => $token
        ]);

    }

     public function getUser() 
    {
        $currentUser = auth()->user();

        return response()->json([
            "messege" => "Berhasil get user",
            "user" => $currentUser
        ]);

    }

     public function login(Request $request) {
        $credentials = request(['email', 'password']);

        if (!$user = auth()->attempt($credentials)) {
            return response()->json([
                'messege' => 'user invalid'
            ], 401);
        }
        $userData = User::where('email', $request['email'])->first();
        $token = JWTAuth::fromUser($userData);

        return response()->json([
            "messege" => "Login Berhasil",
            "user" => $userData,
            "token" => $token
        ]);

    }

     public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'message' => 'Berhasil logout'
        ]);
    }
}
