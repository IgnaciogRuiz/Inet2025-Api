<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\HistoricalOrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\HistoricalOrders;
use Carbon\Carbon;
use GraphQL\Error\Error;

class HistoricalOrderMutation
{
        public function archive($root, array $args): HistoricalOrders
    {
        return DB::transaction(function () use ($args) {

            // Buscar la orden que pertenezca al usuario autenticado
            $order = Order::with(['orderDetails.product'])->where('id', $args['order_id'])->first();

            if (!$order) {
                throw new Error('Orden no encontrada');
            }

            
            // Verificar que la orden esté en un estado que permita archivar
            if ($args['new_status'] != 'cancelled' && $args['new_status'] != 'delivered') {
                throw new Error('Solo se pueden archivar órdenes entregadas o canceladas');
            }

            // Crear el registro histórico de la orden
            $historicalOrder = HistoricalOrders::create([
                'user_id' => $order->user_id,
                'original_order_id' => $order->id,
                'total' => $order->total,
                'status' => $order->status,
                'order_date' => $order->created_at,
                'archived_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            // Migrar los detalles de la orden
            foreach ($order->orderDetails as $detail) {
                HistoricalOrderDetails::create([
                    'historical_order_id' => $historicalOrder->id,
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->name,
                    'product_code' => $detail->product->product_code,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->quantity * $detail->price,
                ]);
            }

            // Eliminar la orden original y sus detalles (pivot)
            $order->orderDetails()->delete();
            $order->delete(); // Eliminar la orden

            return $historicalOrder->fresh(['user', 'historicalOrderDetails']);
        });
    }
}
