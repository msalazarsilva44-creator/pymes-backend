<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Plomería', 'descripcion' => 'Servicios de plomería y fontanería', 'icono' => '🔧'],
            ['nombre' => 'Electricidad', 'descripcion' => 'Instalaciones y reparaciones eléctricas', 'icono' => '⚡'],
            ['nombre' => 'Carpintería', 'descripcion' => 'Trabajos en madera y muebles', 'icono' => '🪚'],
            ['nombre' => 'Pintura', 'descripcion' => 'Pintura residencial y comercial', 'icono' => '🎨'],
            ['nombre' => 'Limpieza', 'descripcion' => 'Servicios de limpieza profesional', 'icono' => '🧹'],
            ['nombre' => 'Jardinería', 'descripcion' => 'Mantenimiento de jardines y áreas verdes', 'icono' => '🌳'],
            ['nombre' => 'Cerrajería', 'descripcion' => 'Cerrajeros y servicios de seguridad', 'icono' => '🔑'],
            ['nombre' => 'Aire Acondicionado', 'descripcion' => 'Instalación y mantenimiento de A/C', 'icono' => '❄️'],
            ['nombre' => 'Mudanzas', 'descripcion' => 'Servicios de mudanza y transporte', 'icono' => '📦'],
            ['nombre' => 'Albañilería', 'descripcion' => 'Construcción y remodelación', 'icono' => '🏗️'],
            ['nombre' => 'Herrería', 'descripcion' => 'Trabajos en metal y herrería', 'icono' => '⚒️'],
            ['nombre' => 'Vidriería', 'descripcion' => 'Instalación y reparación de vidrios', 'icono' => '🪟'],
            ['nombre' => 'Fumigación', 'descripcion' => 'Control de plagas', 'icono' => '🦟'],
            ['nombre' => 'Techado', 'descripcion' => 'Reparación e instalación de techos', 'icono' => '🏠'],
            ['nombre' => 'Mascotas', 'descripcion' => 'Veterinarias y servicios para mascotas', 'icono' => '🐕'],
        ];

        foreach ($categorias as $categoria) {
            $slug = Str::slug($categoria['nombre']);
            Categoria::firstOrCreate(
                ['slug' => $slug],
                [
                    'nombre' => $categoria['nombre'],
                    'slug' => $slug,
                    'descripcion' => $categoria['descripcion'],
                    'icono' => $categoria['icono'],
                    'activa' => true,
                ]
            );
        }

        $this->command->info('✅ Categorías creadas exitosamente');
    }
}

