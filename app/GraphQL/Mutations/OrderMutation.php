<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GraphQL\Error\Error;

class OrderMutation
{
    public function createFromCart($root, array $args): Order
    {
        return DB::transaction(function () {
            $user = Auth::guard('api')->user();

            if (!$user) {
                throw new Error('Usuario no autenticado');
            }

            // Obtener los ítems del carrito
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                throw new Error('El carrito está vacío');
            }

            // Crear la orden
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);

            // Crear los detalles de orden
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'subtotal_price' => $item->product->price * $item->quantity,
                ]);
            }

            // Vaciar el carrito
            Cart::where('user_id', $user->id)->delete();

            return $order->fresh(['orderDetails.product']);
        });
    }

    public function update($root, array $args): Order
    {
        // Validar los datos de entrada
        $validator = Validator::make($args, [
            'id' => 'required|exists:orders,id',
            'input.status' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
        }

        // Buscar la orden que pertenezca al usuario autenticado
        $order = Order::where('id', $args['id'])
            ->first();


        // Actualizar la orden
        $order->update($args['input']);

        return $order->fresh(['orderDetails', 'user']);
    }
}
