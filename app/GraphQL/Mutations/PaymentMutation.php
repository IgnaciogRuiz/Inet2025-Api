<?php

namespace App\GraphQL\Mutations;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use GraphQL\Error\Error;

class PaymentMutation
{
    public function create($root, array $args): Payment
    {
        // Validar los datos de entrada
        $validator = Validator::make($args['input'], [
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
        }

        $user = Auth::guard('api')->user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Verificar que la orden pertenezca al usuario autenticado
        $order = Order::where('id', $args['input']['order_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            throw new Error('Orden no encontrada o no pertenece al usuario');
        }

        // Agregar la fecha actual automáticamente como string
        $paymentData = $args['input'];
        $paymentData['date'] = Carbon::now()->toDateTimeString();

        // Crear el pago
        $payment = Payment::create($paymentData);

        // Recargar el payment
        $payment = $payment->fresh(['order']);

        return $payment;
    }
}
