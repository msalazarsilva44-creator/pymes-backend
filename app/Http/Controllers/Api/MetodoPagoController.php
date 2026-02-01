<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MetodoPagoEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetodoPagoController extends Controller
{
    /**
     * Obtener métodos de pago de la empresa del usuario
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $metodos = MetodoPagoEmpresa::where('empresa_id', $empresa->id)->get();

        // Formatear respuesta con todos los tipos
        $response = [
            'paypal' => null,
            'binance' => null,
            'transferencia' => null,
            'pago_movil' => null,
        ];

        foreach ($metodos as $metodo) {
            $response[$metodo->tipo] = $metodo;
        }

        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }

    /**
     * Obtener métodos de pago de una empresa específica (público)
     */
    public function getByEmpresa($empresaId)
    {
        $metodos = MetodoPagoEmpresa::where('empresa_id', $empresaId)
            ->where('activo', true)
            ->get()
            ->map(function($m) {
                return [
                    'tipo' => $m->tipo,
                    'tipo_nombre' => $m->tipo_nombre,
                    'datos' => $m->datos_formateados,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $metodos
        ]);
    }

    /**
     * Guardar/actualizar métodos de pago
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'tipo' => 'required|in:paypal,binance,transferencia,pago_movil',
            'activo' => 'boolean',
            // PayPal
            'paypal_email' => 'nullable|email|max:255',
            // Binance
            'binance_email' => 'nullable|email|max:255',
            'binance_id' => 'nullable|string|max:100',
            // Transferencia
            'banco_nombre' => 'nullable|string|max:100',
            'banco_cuenta' => 'nullable|string|max:50',
            'banco_titular' => 'nullable|string|max:255',
            'banco_cedula' => 'nullable|string|max:20',
            'banco_tipo_cuenta' => 'nullable|in:corriente,ahorro',
            // Pago Móvil
            'pago_movil_banco' => 'nullable|string|max:10',
            'pago_movil_cedula' => 'nullable|string|max:20',
            'pago_movil_telefono' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buscar o crear método de pago
        $metodo = MetodoPagoEmpresa::updateOrCreate(
            [
                'empresa_id' => $empresa->id,
                'tipo' => $request->tipo,
            ],
            array_merge(
                ['activo' => $request->activo ?? true],
                $this->getDatosMetodo($request)
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Método de pago guardado exitosamente',
            'data' => $metodo
        ]);
    }

    /**
     * Eliminar/desactivar método de pago
     */
    public function destroy(Request $request, $tipo)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $metodo = MetodoPagoEmpresa::where('empresa_id', $empresa->id)
            ->where('tipo', $tipo)
            ->first();

        if (!$metodo) {
            return response()->json([
                'success' => false,
                'message' => 'Método de pago no encontrado'
            ], 404);
        }

        $metodo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Método de pago eliminado'
        ]);
    }

    /**
     * Extraer datos específicos del método de pago
     */
    private function getDatosMetodo(Request $request)
    {
        $datos = [];

        switch ($request->tipo) {
            case 'paypal':
                $datos['paypal_email'] = $request->paypal_email;
                break;
            case 'binance':
                $datos['binance_email'] = $request->binance_email;
                $datos['binance_id'] = $request->binance_id;
                break;
            case 'transferencia':
                $datos['banco_nombre'] = $request->banco_nombre;
                $datos['banco_cuenta'] = $request->banco_cuenta;
                $datos['banco_titular'] = $request->banco_titular;
                $datos['banco_cedula'] = $request->banco_cedula;
                $datos['banco_tipo_cuenta'] = $request->banco_tipo_cuenta;
                break;
            case 'pago_movil':
                $datos['pago_movil_banco'] = $request->pago_movil_banco;
                $datos['pago_movil_cedula'] = $request->pago_movil_cedula;
                $datos['pago_movil_telefono'] = $request->pago_movil_telefono;
                break;
        }

        return $datos;
    }
}
