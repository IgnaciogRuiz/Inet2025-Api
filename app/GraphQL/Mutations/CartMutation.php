<?php

namespace App\GraphQL\Mutations;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use GraphQL\Error\Error;

class CartMutation
{
    public function add($root, array $args): Cart
    {
        // Validar los datos de entrada
        $validator = Validator::make($args, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
        }

        $user = Auth::user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Verificar si el producto ya está en el carrito del usuario
        $existingCart = Cart::where('user_id', $user->id)
            ->where('product_id', $args['product_id'])
            ->first();

        if ($existingCart) {
            // Si ya existe, actualizar la cantidad
            $existingCart->quantity += $args['quantity'];
            $existingCart->save();
            return $existingCart->fresh(['user', 'product']);
        } else {
            // Si no existe, crear nuevo registro
            $cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $args['product_id'],
                'quantity' => $args['quantity'],
            ]);

            return $cart->fresh(['user', 'product']);
        }
    }


    public function remove($root, array $args): bool
    {
        // Validar los datos de entrada
        $validator = Validator::make($args, [
            'cart_id' => 'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
        }

        $user = Auth::user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Buscar el registro del carrito
        $cart = Cart::where('id', $args['cart_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$cart) {
            throw new Error('Producto no encontrado en el carrito del usuario');
        }

        // Eliminar el registro
        return $cart->delete();
    }

    public function clear($root, array $args): bool
    {
        $user = Auth::user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Eliminar todos los registros del carrito del usuario
        return Cart::where('user_id', $user->id)->delete() > 0;
    }
}
