<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => [
                'required'
            ],
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials, $remember)){
            return response([
                'error' => 'Xác thực không hợp lệ'
            ], 422);
        }
        $user = Auth::user();
        $user_info =  $user->staff();
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true,
        ]);
    }
}
