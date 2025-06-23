<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;



class AuthenticatedSessionController extends Controller
{
    /**
     * Login Request
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $user = User::where('email', $request->input('email'))->firstOrFail();

        // Crear nuevo token
        $token = $user->createToken('')->accessToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'admin' => $user->admin,
                ]
            ],

        ]);
    }

    /**
     * Logout Request
     * 
     * Destruye el BearerToken de la session.
     */
    public function destroy(Request $request)
    {
        $accessToken = $request->user()->token();
        $accessToken->revoke();

        return response()->noContent();
    }
}
