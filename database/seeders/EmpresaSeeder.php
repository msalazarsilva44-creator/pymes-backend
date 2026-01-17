<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Ciudad;
use App\Models\Plan;
use App\Models\Servicio;
use App\Models\Horario;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        $empresaUsers = User::whereHas('role', function($q) {
            $q->where('name', 'empresa');
        })->get();

        $categorias = Categoria::all();
        $ciudades = Ciudad::all();
        $planes = Plan::all();

        $empresasData = [
            [
                'nombre_comercial' => 'Plomería Rápida CCS',
                'categoria' => 'Plomería',
                'ciudad' => 'Distrito Capital',
                'plan' => 'premium',
                'descripcion' => 'Servicios de plomería 24/7 con más de 15 años de experiencia. Atendemos emergencias.',
                'telefono' => '02121234567',
                'whatsapp' => '04241234567',
                'direccion' => 'Av. Francisco de Miranda, Caracas',
                'servicios' => [
                    ['nombre' => 'Reparación de fugas', 'precio_desde' => 350],
                    ['nombre' => 'Destapado de drenaje', 'precio_desde' => 450],
                    ['nombre' => 'Instalación de calentador', 'precio_desde' => 1200],
                ]
            ],
            [
                'nombre_comercial' => 'Electricidad Segura',
                'categoria' => 'Electricidad',
                'ciudad' => 'Miranda',
                'plan' => 'basico',
                'descripcion' => 'Instalaciones eléctricas residenciales y comerciales. Personal certificado.',
                'telefono' => '02129876543',
                'direccion' => 'Av. Principal de Los Ruices, Miranda',
                'servicios' => [
                    ['nombre' => 'Instalación de contactos', 'precio_desde' => 200],
                    ['nombre' => 'Revisión eléctrica', 'precio_desde' => 500],
                ]
            ],
            [
                'nombre_comercial' => 'Carpintería Artesanal',
                'categoria' => 'Carpintería',
                'ciudad' => 'Carabobo',
                'plan' => 'gratis',
                'descripcion' => 'Muebles a medida y trabajos en madera de calidad.',
                'telefono' => '02415551234',
                'direccion' => 'Av. Bolívar Norte, Valencia',
                'servicios' => [
                    ['nombre' => 'Closet a medida', 'precio_desde' => 8000],
                    ['nombre' => 'Reparación de muebles', 'precio_desde' => 500],
                ]
            ],
        ];

        foreach ($empresasData as $index => $data) {
            $user = $empresaUsers->get($index);
            if (!$user) continue;

            $categoria = $categorias->where('nombre', $data['categoria'])->first();
            $ciudad = $ciudades->where('nombre', $data['ciudad'])->first();
            $plan = $planes->where('slug', $data['plan'])->first();

            $empresa = Empresa::create([
                'user_id' => $user->id,
                'categoria_id' => $categoria->id,
                'ciudad_id' => $ciudad->id,
                'plan_id' => $plan->id,
                'nombre_comercial' => $data['nombre_comercial'],
                'descripcion' => $data['descripcion'],
                'telefono' => $data['telefono'],
                'email_contacto' => $user->email,
                'whatsapp' => $data['whatsapp'] ?? null,
                'direccion' => $data['direccion'],
                'verificado' => $data['plan'] !== 'gratis',
                'verificado_at' => $data['plan'] !== 'gratis' ? now() : null,
                'calificacion_promedio' => rand(40, 50) / 10,
                'total_resenas' => rand(5, 25),
                'total_vistas' => rand(100, 500),
                'total_clics' => rand(20, 100),
                'activo' => true,
                'aprobado' => true, // Empresas de prueba aprobadas automáticamente
                'aprobado_at' => now(),
                'aprobado_por' => 1, // Admin
            ]);

            // Crear servicios
            foreach ($data['servicios'] as $servicio) {
                Servicio::create([
                    'empresa_id' => $empresa->id,
                    'nombre' => $servicio['nombre'],
                    'precio_desde' => $servicio['precio_desde'],
                    'activo' => true,
                ]);
            }

            // Crear horarios
            $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
            foreach ($dias as $dia) {
                Horario::create([
                    'empresa_id' => $empresa->id,
                    'dia_semana' => $dia,
                    'hora_apertura' => '09:00',
                    'hora_cierre' => '18:00',
                    'cerrado' => false,
                ]);
            }

            // Domingo cerrado
            Horario::create([
                'empresa_id' => $empresa->id,
                'dia_semana' => 'domingo',
                'cerrado' => true,
            ]);
        }

        $this->command->info('✅ Empresas de prueba creadas exitosamente');
    }
}

