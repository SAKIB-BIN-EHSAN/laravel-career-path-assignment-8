<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $status = DB::table('users')->insert([
            'fname' => $validatedData['first_name'],
            'lname' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if ($status) {
            return to_route('login');
        } else {
            return back();
        }
    }
}
