<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;



class RegisteredUserController extends Controller
{
    /**
     * Register a new account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname'     => 'required|string|min:4',
            'lastname'     => 'required|string|min:4',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'repassword' => 'required|string|same:password',
        ]);

        try {
            $user = new User();
            $user->firstname      = $request->firstname;
            $user->lastname      = $request->lastname;
            $user->email     = $request->email;
            $user->password  = Hash::make($request->password);
            $user->admin = false; // Default to non-admin user
            $user->save();

            return response()->json([
                'response_code' => 201,
                'status'        => 'success',
                'message'       => 'Successfully registered',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());

            return response()->json([
                'response_code' => 500,
                'status'        => 'error',
                'message'       => 'Registration failed',
            ], 500);
        }
    }
}
