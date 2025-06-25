<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Flight;
use App\Models\Stay;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GraphQL\Error\Error;

class ProductMutation
{
    public function createFull($root, array $args): array
    {
        return DB::transaction(function () use ($args) {
            // Validar los datos de entrada
            $validator = Validator::make($args['input'], [
                'product_code' => 'required|string|max:255|unique:products,product_code',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'scope' => 'required|string',
                'capacity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
            }

            // Crear producto base
            $product = Product::create($args['input']);
            // Crear vuelo si existe y asociar
            if (!empty($args['flight'])) {
                $flight = Flight::create($args['flight']);
                $product->flights()->attach($flight->id);
            }
            // Crear estadía si existe y asociar
            if (!empty($args['stay'])) {
                $stay = Stay::create($args['stay']);
                $product->stays()->attach($stay->stay_id);
            }
            // Crear auto si existe y asociar
            if (!empty($args['car'])) {
                $car = Car::create($args['car']);
                $product->cars()->attach($car->id);
            }
            // Recargar relaciones
            return [
                'message' => 'Producto creado correctamente',
                'product' => $product->fresh(['flights', 'stays', 'cars']),
            ];
        });
    }

    public function update($root, array $args): Product
    {
        return DB::transaction(function () use ($args) {
            // Buscar el producto por ID
            $product = Product::find($args['id']);

            if (!$product) {
                throw new Error('Producto no encontrado');
            }

            // Validar los datos de entrada
            $validator = Validator::make($args['input'], [
                'product_code' => 'sometimes|string|max:255|unique:products,product_code,' . $args['id'],
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric|min:0',
                'scope' => 'sometimes|string',
                'capacity_id' => 'sometimes|integer|min:1',
            ]);

            if ($validator->fails()) {
                throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
            }

            // Actualizar el producto con los datos proporcionados
            $product->update($args['input']);

            // Actualizar o crear vuelo si viene en args
            if (!empty($args['flight'])) {
                // Si ya tiene vuelos asociados, actualizalos (suponiendo 1 vuelo por producto, sino hay que adaptar)
                if ($product->flights()->exists()) {
                    // Actualizar el primer vuelo asociado (si hay más, lógica a adaptar)
                    $flight = $product->flights()->first();
                    $flight->update($args['flight']);
                } else {
                    // Crear nuevo vuelo y asociar
                    $flight = Flight::create($args['flight']);
                    $product->flights()->attach($flight->id);
                }
            }

            // Actualizar o crear estadía
            if (!empty($args['stay'])) {
                if ($product->stays()->exists()) {
                    $stay = $product->stays()->first();
                    $stay->update($args['stay']);
                } else {
                    $stay = Stay::create($args['stay']);
                    $product->stays()->attach($stay->id);
                }
            }

            // Actualizar o crear auto
            if (!empty($args['car'])) {
                if ($product->cars()->exists()) {
                    $car = $product->cars()->first();
                    $car->update($args['car']);
                } else {
                    $car = Car::create($args['car']);
                    $product->cars()->attach($car->id);
                }
            }

            // Recargar relaciones
            return [
                'message' => 'Producto actualizado correctamente',
                'product' => $product->fresh(['flights', 'stays', 'cars']),
            ];
        });

            
    }
    public function toggleProductEnabled($root, array $args): array
{
    $product = Product::find($args['id']);
    
    if (!$product) {
        throw new Error('Producto no encontrado');
    }

    $product->active = !$product->active;
    $product->save();

    return [
        'success' => true,
        'message' => $product->active ? 'Producto habilitado' : 'Producto deshabilitado',
    ];
}
}
