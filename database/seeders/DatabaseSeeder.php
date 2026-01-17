<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CiudadSeeder::class,
            MunicipioSeeder::class,
            CategoriaSeeder::class,
            PlanSeeder::class,
            UserSeeder::class,
            EmpresaSeeder::class,
        ]);
    }
}

