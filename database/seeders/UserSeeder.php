<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $clienteRole = Role::where('name', 'cliente')->first();
        $empresaRole = Role::where('name', 'empresa')->first();

        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@servilocal.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'phone' => '3331234567',
            'is_active' => true,
        ]);

        // Cliente de prueba
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'cliente@test.com',
            'password' => Hash::make('password'),
            'role_id' => $clienteRole->id,
            'phone' => '3339876543',
            'is_active' => true,
        ]);

        // Empresas de prueba
        $empresas = [
            ['name' => 'María González', 'email' => 'maria@plomeria.com'],
            ['name' => 'Carlos Ramírez', 'email' => 'carlos@electricidad.com'],
            ['name' => 'Ana López', 'email' => 'ana@carpinteria.com'],
        ];

        foreach ($empresas as $empresa) {
            User::create([
                'name' => $empresa['name'],
                'email' => $empresa['email'],
                'password' => Hash::make('password'),
                'role_id' => $empresaRole->id,
                'phone' => '333' . rand(1000000, 9999999),
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Usuarios creados exitosamente');
        $this->command->info('📧 Admin: admin@servilocal.com | password: password');
        $this->command->info('📧 Cliente: cliente@test.com | password: password');
    }
}

