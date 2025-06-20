<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GraphQL\Error\Error;

class UserQuery
{
    public function me($root, array $args)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        return $user;
    }


    public function orders($root, array $args)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Usar Eloquent para que GraphQL pueda acceder a las relaciones
        return Order::with('orderDetails.product')
            ->where('user_id', $user->id)
            ->get();
    }
}
