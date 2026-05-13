<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    /**
     * Obtener perfil del cliente autenticado
     */
    public function perfil(Request $request)
    {
        try {
            $user = $request->user()->loadMissing(['ciudad', 'municipio']);

            $totalPedidos = \App\Models\Orden::where('user_id', $user->id)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'email' => $user->email,
                    'telefono' => $user->phone ?? null,
                    'direccion' => $user->direccion ?? null,
                    'ciudad_id' => $user->ciudad_id,
                    'municipio_id' => $user->municipio_id,
                    'ciudad' => $user->ciudad?->nombre,
                    'municipio' => $user->municipio?->nombre,
                    'referencia_direccion' => $user->referencia_direccion,
                    'avatar' => $user->avatar ? '/storage/' . $user->avatar : null,
                    'miembro_desde' => $user->created_at->format('M Y'),
                    'total_pedidos' => $totalPedidos,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener perfil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar perfil del cliente
     */
    public function actualizar(Request $request)
    {
        try {
            $user = $request->user();

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'telefono' => 'nullable|string|max:40',
                'direccion' => 'nullable|string|max:500',
                'ciudad_id' => 'nullable|exists:ciudades,id',
                'municipio_id' => 'nullable|exists:municipios,id',
                'referencia_direccion' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|max:2048',
                'avatar_remove' => 'nullable|boolean',
            ]);

            $map = [];
            if (array_key_exists('nombre', $validated)) $map['name'] = $validated['nombre'];
            if (array_key_exists('email', $validated)) $map['email'] = $validated['email'];
            if (array_key_exists('telefono', $validated)) $map['phone'] = $validated['telefono'];
            if (array_key_exists('direccion', $validated)) $map['direccion'] = $validated['direccion'];
            if (array_key_exists('ciudad_id', $validated)) $map['ciudad_id'] = $validated['ciudad_id'];
            if (array_key_exists('municipio_id', $validated)) $map['municipio_id'] = $validated['municipio_id'];
            if (array_key_exists('referencia_direccion', $validated)) $map['referencia_direccion'] = $validated['referencia_direccion'];

            // Avatar upload
            if ($request->hasFile('avatar')) {
                // Borrar avatar anterior si existe
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $ext = $request->file('avatar')->getClientOriginalExtension();
                $filename = 'avatars/' . $user->id . '_' . time() . '.' . $ext;
                $request->file('avatar')->storeAs('public', $filename);
                $map['avatar'] = $filename;
            } elseif ($request->boolean('avatar_remove')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $map['avatar'] = null;
            }

            $user->update($map);
            $user->refresh()->loadMissing(['ciudad', 'municipio']);

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente',
                'data' => [
                    'nombre' => $user->name,
                    'email' => $user->email,
                    'telefono' => $user->phone,
                    'direccion' => $user->direccion,
                    'ciudad_id' => $user->ciudad_id,
                    'municipio_id' => $user->municipio_id,
                    'ciudad' => $user->ciudad?->nombre,
                    'municipio' => $user->municipio?->nombre,
                    'referencia_direccion' => $user->referencia_direccion,
                    'avatar' => $user->avatar ? '/storage/' . $user->avatar : null,
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar perfil',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
