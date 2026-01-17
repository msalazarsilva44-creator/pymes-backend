<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrador del sistema'],
            ['name' => 'empresa', 'description' => 'Empresa proveedora de servicios'],
            ['name' => 'cliente', 'description' => 'Cliente que busca servicios'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('✅ Roles creados exitosamente');
    }
}

