<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Empresa;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registro de Cliente
     */
    public function registerCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'cedula' => 'required|string|size:11|regex:/^\d{11}$/|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ], [
            'cedula.required' => 'La cédula es obligatoria',
            'cedula.size' => 'La cédula debe tener exactamente 11 dígitos',
            'cedula.regex' => 'La cédula debe contener solo números',
            'cedula.unique' => 'Esta cédula ya está registrada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $roleCliente = Role::where('name', 'cliente')->first();

        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleCliente->id,
            'phone' => $request->phone,
            'direccion' => $request->direccion,
            'is_active' => true,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado exitosamente',
            'data' => [
                'user' => $user->load('role'),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }

    /**
     * Registro de Empresa
     */
    public function registerEmpresa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Usuario
            'name' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            
            // Empresa
            'nombre_comercial' => 'required|string|max:255',
            'rfc' => 'nullable|string|max:10',
            'documento_rif' => 'required|file|mimes:pdf|max:5120',
            'categoria_id' => 'required|exists:categorias,id',
            'ciudad_id' => 'required|exists:ciudades,id',
            'municipio_id' => 'required|exists:municipios,id',
            'telefono' => 'required|string|max:20',
            'email_contacto' => 'required|email|max:255',
            'direccion' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Procesar archivo PDF del RIF
        $documento_rif_path = null;
        if ($request->hasFile('documento_rif')) {
            $file = $request->file('documento_rif');
            $fileName = 'rif_' . time() . '_' . uniqid() . '.pdf';
            $file->storeAs('public/documentos_rif', $fileName);
            $documento_rif_path = 'documentos_rif/' . $fileName;
        }

        // Crear usuario
        $roleEmpresa = Role::where('name', 'empresa')->first();
        
        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleEmpresa->id,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        // Obtener plan gratuito por defecto
        $planGratis = Plan::where('slug', 'gratis')->first();

        // Crear empresa
        $empresa = Empresa::create([
            'user_id' => $user->id,
            'categoria_id' => $request->categoria_id,
            'ciudad_id' => $request->ciudad_id,
            'municipio_id' => $request->municipio_id,
            'plan_id' => $planGratis->id,
            'nombre_comercial' => $request->nombre_comercial,
            'rfc' => $request->rfc,
            'documento_rif' => $documento_rif_path,
            'descripcion' => $request->descripcion,
            'telefono' => $request->telefono,
            'email_contacto' => $request->email_contacto,
            'direccion' => $request->direccion,
            'activo' => true,
            'aprobado' => false, // La empresa debe ser aprobada por el admin antes de aparecer en el marketplace
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Empresa registrada exitosamente. Tu perfil está pendiente de aprobación por el administrador.',
            'data' => [
                'user' => $user->load('role'),
                'empresa' => $empresa->load(['categoria', 'ciudad', 'plan']),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta ha sido suspendida. Contacta al administrador.'
            ], 403);
        }

        // Eliminar tokens anteriores
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'user' => $user->load('role'),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        // Si es empresa, cargar datos de la empresa
        if ($user->isEmpresa() && $user->empresa) {
            $data['empresa'] = $user->empresa->load(['categoria', 'ciudad', 'plan']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'data' => $data
        ], 200);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ], 200);
    }

    /**
     * Obtener usuario autenticado
     */
    public function me(Request $request)
    {
        $user = $request->user()->load('role');

        // Si es empresa, cargar datos de la empresa
        if ($user->isEmpresa() && $user->empresa) {
            $user->empresa = $user->empresa->load([
                'categoria', 
                'ciudad', 
                'plan',
                'fotos',
                'servicios',
                'productos.imagenes',
                'horarios'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $user  // Devolver usuario directamente en data
        ], 200);
    }

    /**
     * Actualizar perfil
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only(['name', 'phone', 'avatar']));

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado exitosamente',
            'data' => [
                'user' => $user->load('role')
            ]
        ], 200);
    }

    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual es incorrecta'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada exitosamente'
        ], 200);
    }
}

