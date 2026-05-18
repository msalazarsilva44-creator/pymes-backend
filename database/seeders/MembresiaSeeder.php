<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class MembresiaSeeder extends Seeder
{
    public function run(): void
    {
        // Actualizar el plan Básico existente con los nuevos campos
        $basico = Plan::where('slug', 'basico')->first();

        if ($basico) {
            $basico->update([
                'caracteristicas' => [
                    'Perfil de empresa publicado',
                    'Hasta 10 servicios publicados',
                    'Soporte por email',
                ],
                'color_badge' => 'blue',
                'destacado' => true,
                'orden' => 1,
            ]);
        } else {
            Plan::create([
                'nombre' => 'Básico',
                'slug' => 'basico',
                'descripcion' => 'Plan inicial para proveedores',
                'precio_mensual' => 2.00,
                'precio_anual' => 24.00,
                'posicion_prioridad' => 1,
                'max_fotos' => 3,
                'panel_metricas' => false,
                'notificaciones_push' => false,
                'verificacion_perfil' => false,
                'activo' => true,
                'caracteristicas' => [
                    'Perfil de empresa publicado',
                    'Hasta 10 servicios publicados',
                    'Soporte por email',
                ],
                'color_badge' => 'blue',
                'destacado' => true,
                'orden' => 1,
            ]);
        }
    }
}
