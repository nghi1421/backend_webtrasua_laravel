<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Staff;
use App\Models\Customer;

class AuthController extends Controller
{
    public function register(Request $request){
        // $data =  $request->all();
        $data = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'role_id' => 'required',
            'staff_id' => 'required',
        ]);

        /** @var \App\Models\User $user */
        $user = User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role_id' => $data['role_id'],

        ]);
        
        $token = $user->createToken('main')->plainTextToken;

        $staff_inf = Staff::where('id',$data['staff_id'])->first();
        $staff_inf['id_login'] = $user['id'];
        $staff_inf->save();

        return response([
            'staff_information' => $staff_inf,
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
        $role = $user->role();

        $user_info =  Staff::where('id_login',$user['id'])->first();
        if(!$user_info){
            $user_info =  Customer::where('id_login',$user['id'])->first();
        }
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'role' => $role,
            'information' => $user_info,
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
