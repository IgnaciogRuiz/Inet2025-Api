<?php

namespace App\GraphQL\Mutations;

use App\Models\Residence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GraphQL\Error\Error;

class ResidenceMutation
{
    public function create($root, array $args): Residence
    {
        // Validar los datos de entrada
        $validator = Validator::make($args['input'], [
            'zip_code' => 'required|string|max:20',
            'locality' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
        }

        $user = Auth::guard('api')->user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Crear la residencia
        $residence = Residence::create($args['input']);

        // Insertar directamente en la tabla pivot
        DB::table('residence_user')->insert([
            'user_id' => $user->id,
            'residence_id' => $residence->id,
        ]);

        return $residence->fresh();
    }

    public function update($root, array $args): Residence
    {
        // Validar los datos de entrada
        $validator = Validator::make($args['input'], [
            'id' => 'required|exists:residences,id',
            'zip_code' => 'sometimes|string|max:20',
            'locality' => 'sometimes|string|max:255',
            'street' => 'sometimes|string|max:255',
            'number' => 'sometimes|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new Error('Datos de entrada inválidos: ' . $validator->errors()->first());
        }

        $user = Auth::guard('api')->user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Buscar la residencia que pertenezca al usuario autenticado
        $residence = DB::table('residence_user')
            ->join('residences', 'residences.id', '=', 'residence_user.residence_id')
            ->where('residence_user.user_id', $user->id)
            ->where('residences.id', $args['input']['id'])
            ->select('residences.*')
            ->first();

        if (!$residence) {
            throw new Error('Residencia no encontrada o no pertenece al usuario');
        }

        // Actualizar la residencia
        $residenceModel = Residence::find($residence->id);
        $residenceModel->update($args['input']);

        return $residenceModel->fresh();
    }

    public function delete($root, array $args): bool
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            throw new Error('Usuario no autenticado');
        }

        // Verificar si la residencia pertenece al usuario
        $residence = DB::table('residence_user')
            ->where('user_id', $user->id)
            ->where('residence_id', $args['id'])
            ->first();

        if (!$residence) {
            throw new Error('Residencia no encontrada o no pertenece al usuario');
        }

        // Eliminar la relación en la tabla pivote
        DB::table('residence_user')
            ->where('user_id', $user->id)
            ->where('residence_id', $args['id'])
            ->delete();

        // Eliminar la residencia en sí
        return Residence::destroy($args['id']) > 0;
    }
}
