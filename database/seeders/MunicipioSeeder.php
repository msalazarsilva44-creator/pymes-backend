<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;
use App\Models\Municipio;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        $municipiosPorEstado = [
            'Distrito Capital' => [
                'Libertador',
            ],
            'Miranda' => [
                'Baruta', 'Chacao', 'El Hatillo', 'Sucre', 'Guaicaipuro', 
                'Los Salias', 'Plaza', 'Zamora', 'Carrizal', 'Independencia',
            ],
            'Carabobo' => [
                'Valencia', 'Naguanagua', 'San Diego', 'Los Guayos', 'Libertador',
                'Carlos Arvelo', 'Guacara', 'Puerto Cabello', 'San Joaquín',
            ],
            'Zulia' => [
                'Maracaibo', 'San Francisco', 'Jesús Enrique Lossada', 'Cabimas', 
                'Lagunillas', 'Santa Rita', 'Mara', 'Machiques', 'Miranda',
            ],
            'Aragua' => [
                'Girardot', 'Mario Briceño Iragorry', 'Santiago Mariño', 'José Félix Ribas',
                'Sucre', 'Libertador', 'Santos Michelena', 'José Rafael Revenga',
            ],
            'Lara' => [
                'Iribarren', 'Palavecino', 'Torres', 'Jiménez', 'Morán',
                'Crespo', 'Andrés Eloy Blanco', 'Simón Planas',
            ],
            'Anzoátegui' => [
                'Simón Bolívar', 'Juan Antonio Sotillo', 'Guanta', 'Urbaneja',
                'Peñalver', 'Freites', 'Aragua', 'Independencia',
            ],
            'Bolívar' => [
                'Heres', 'Caroní', 'Piar', 'Roscio', 'Sifontes',
                'Padre Pedro Chien', 'Angostura', 'Cedeño',
            ],
            'Táchira' => [
                'San Cristóbal', 'Cárdenas', 'Andrés Bello', 'Libertador',
                'Pedro María Ureña', 'Sucre', 'Junín', 'Independencia',
            ],
            'Mérida' => [
                'Libertador', 'Santos Marquina', 'Campo Elías', 'Sucre',
                'Rangel', 'Julio César Salas', 'Tovar', 'Miranda',
            ],
            'Falcón' => [
                'Carirubana', 'Falcón', 'Miranda', 'Los Taques',
                'Mauroa', 'Petit', 'Monseñor Iturriza', 'Silva',
            ],
            'Monagas' => [
                'Maturín', 'Piar', 'Caripe', 'Libertador',
                'Aguasay', 'Cedeño', 'Ezequiel Zamora', 'Santa Bárbara',
            ],
            'Sucre' => [
                'Sucre', 'Bermúdez', 'Mejía', 'Montes', 'Mariño',
                'Arismendi', 'Cruz Salmerón Acosta', 'Ribero',
            ],
            'Barinas' => [
                'Barinas', 'Bolívar', 'Pedraza', 'Rojas', 'Obispos',
                'Antonio José de Sucre', 'Alberto Arvelo Torrealba', 'Ezequiel Zamora',
            ],
            'Portuguesa' => [
                'Guanare', 'Araure', 'Páez', 'Turén', 'Ospino',
                'Santa Rosalía', 'Agua Blanca', 'Esteller',
            ],
            'Trujillo' => [
                'Valera', 'Trujillo', 'Escuque', 'Boconó', 'Monte Carmelo',
                'Pampán', 'Motatán', 'San Rafael de Carvajal',
            ],
            'Yaracuy' => [
                'San Felipe', 'Independencia', 'Nirgua', 'Urachiche',
                'Bolívar', 'Bruzual', 'Cocorote', 'Manuel Monge',
            ],
            'Nueva Esparta' => [
                'Mariño', 'García', 'Arismendi', 'Maneiro', 'Gómez',
                'Díaz', 'Tubores', 'Villalba',
            ],
            'Apure' => [
                'San Fernando', 'Biruaca', 'Muñoz', 'Achaguas', 'Pedro Camejo',
                'Páez', 'Rómulo Gallegos', 'Guasdualito',
            ],
            'Guárico' => [
                'San Juan de los Morros', 'Roscio', 'Mellado', 'Zaraza',
                'Ribas', 'Miranda', 'Ortiz', 'Chaguaramas',
            ],
            'Cojedes' => [
                'San Carlos', 'Tinaquillo', 'Ricaurte', 'Ezequiel Zamora',
                'Lima Blanco', 'Pao de San Juan', 'Girardot', 'Anzoátegui',
            ],
            'Delta Amacuro' => [
                'Tucupita', 'Antonio Díaz', 'Casacoima', 'Pedernales',
            ],
            'Amazonas' => [
                'Atures', 'Autana', 'Manapiare', 'Maroa', 'Río Negro',
            ],
            'Vargas' => [
                'Vargas',
            ],
        ];

        foreach ($municipiosPorEstado as $estadoNombre => $municipios) {
            $estado = Ciudad::where('nombre', $estadoNombre)->first();
            
            if ($estado) {
                foreach ($municipios as $municipioNombre) {
                    Municipio::create([
                        'nombre' => $municipioNombre,
                        'ciudad_id' => $estado->id,
                    ]);
                }
            }
        }

        $this->command->info('✅ Municipios de Venezuela creados exitosamente');
    }
}
