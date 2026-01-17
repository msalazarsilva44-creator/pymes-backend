<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Gratis',
                'slug' => 'gratis',
                'precio_mensual' => 0,
                'precio_anual' => 0,
                'posicion_prioridad' => 0, // Aparece al final
                'max_fotos' => 1,
                'panel_metricas' => false,
                'notificaciones_push' => false,
                'verificacion_perfil' => false,
                'descripcion' => 'Plan básico gratuito - Perfil simple con 1 foto. Sin panel de métricas ni notificaciones.',
                'activo' => true,
            ],
            [
                'nombre' => 'Básico',
                'slug' => 'basico',
                'precio_mensual' => 5.00,
                'precio_anual' => 54.00, // 10% descuento
                'posicion_prioridad' => 50, // Posición intermedia
                'max_fotos' => 10,
                'panel_metricas' => true,
                'notificaciones_push' => false,
                'verificacion_perfil' => false,
                'descripcion' => 'Boost de 2 días en portada + 10 fotos + Panel de métricas básico + Perfil destacado',
                'activo' => true,
            ],
            [
                'nombre' => 'Premium',
                'slug' => 'premium',
                'precio_mensual' => 10.00,
                'precio_anual' => 108.00, // 10% descuento
                'posicion_prioridad' => 100, // Top por calificación
                'max_fotos' => 999,
                'panel_metricas' => true,
                'notificaciones_push' => true,
                'verificacion_perfil' => true,
                'descripcion' => 'Fotos ilimitadas + Top en categoría + Panel avanzado + Notificaciones + Prioridad por calificación',
                'activo' => true,
            ],
        ];

        foreach ($planes as $plan) {
            Plan::create($plan);
        }

        $this->command->info('✅ Planes creados exitosamente');
    }
}

