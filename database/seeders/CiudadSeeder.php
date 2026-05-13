<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;

class CiudadSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Distrito Capital', 'estado' => 'Distrito Capital', 'pais' => 'Venezuela'],
            ['nombre' => 'Miranda', 'estado' => 'Miranda', 'pais' => 'Venezuela'],
            ['nombre' => 'Carabobo', 'estado' => 'Carabobo', 'pais' => 'Venezuela'],
            ['nombre' => 'Zulia', 'estado' => 'Zulia', 'pais' => 'Venezuela'],
            ['nombre' => 'Aragua', 'estado' => 'Aragua', 'pais' => 'Venezuela'],
            ['nombre' => 'Lara', 'estado' => 'Lara', 'pais' => 'Venezuela'],
            ['nombre' => 'Anzoátegui', 'estado' => 'Anzoátegui', 'pais' => 'Venezuela'],
            ['nombre' => 'Bolívar', 'estado' => 'Bolívar', 'pais' => 'Venezuela'],
            ['nombre' => 'Táchira', 'estado' => 'Táchira', 'pais' => 'Venezuela'],
            ['nombre' => 'Mérida', 'estado' => 'Mérida', 'pais' => 'Venezuela'],
            ['nombre' => 'Falcón', 'estado' => 'Falcón', 'pais' => 'Venezuela'],
            ['nombre' => 'Monagas', 'estado' => 'Monagas', 'pais' => 'Venezuela'],
            ['nombre' => 'Sucre', 'estado' => 'Sucre', 'pais' => 'Venezuela'],
            ['nombre' => 'Barinas', 'estado' => 'Barinas', 'pais' => 'Venezuela'],
            ['nombre' => 'Portuguesa', 'estado' => 'Portuguesa', 'pais' => 'Venezuela'],
            ['nombre' => 'Trujillo', 'estado' => 'Trujillo', 'pais' => 'Venezuela'],
            ['nombre' => 'Yaracuy', 'estado' => 'Yaracuy', 'pais' => 'Venezuela'],
            ['nombre' => 'Nueva Esparta', 'estado' => 'Nueva Esparta', 'pais' => 'Venezuela'],
            ['nombre' => 'Apure', 'estado' => 'Apure', 'pais' => 'Venezuela'],
            ['nombre' => 'Guárico', 'estado' => 'Guárico', 'pais' => 'Venezuela'],
            ['nombre' => 'Cojedes', 'estado' => 'Cojedes', 'pais' => 'Venezuela'],
            ['nombre' => 'Delta Amacuro', 'estado' => 'Delta Amacuro', 'pais' => 'Venezuela'],
            ['nombre' => 'Amazonas', 'estado' => 'Amazonas', 'pais' => 'Venezuela'],
            ['nombre' => 'Vargas', 'estado' => 'Vargas', 'pais' => 'Venezuela'],
        ];

        foreach ($estados as $estado) {
            Ciudad::firstOrCreate(['nombre' => $estado['nombre'], 'pais' => $estado['pais']], $estado);
        }

        $this->command->info('✅ Estados de Venezuela creados exitosamente');
    }
}
