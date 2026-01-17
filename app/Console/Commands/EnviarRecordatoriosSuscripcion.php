<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Suscripcion;
use App\Mail\SuscripcionProximaVencer;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatoriosSuscripcion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suscripciones:enviar-recordatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios por email cuando las suscripciones están por vencer (7, 3, 1 día)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Iniciando envío de recordatorios de suscripción...');
        
        $enviados = 0;
        $errores = 0;

        // 1. Suscripciones que vencen en 7 días
        $this->line('');
        $this->info('🔍 Buscando suscripciones que vencen en 7 días...');
        $suscripciones7dias = Suscripcion::where('estado', 'activa')
            ->whereRaw('DATEDIFF(fecha_fin, NOW()) = 7')
            ->with(['empresa.user', 'plan'])
            ->get();

        foreach ($suscripciones7dias as $suscripcion) {
            try {
                $this->enviarRecordatorio($suscripcion, 7, '7dias');
                $enviados++;
                $this->line("✅ Enviado a: {$suscripcion->empresa->nombre_comercial} (7 días)");
            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error enviando a {$suscripcion->empresa->nombre_comercial}: {$e->getMessage()}");
            }
        }

        // 2. Suscripciones que vencen en 3 días
        $this->line('');
        $this->info('🔍 Buscando suscripciones que vencen en 3 días...');
        $suscripciones3dias = Suscripcion::where('estado', 'activa')
            ->whereRaw('DATEDIFF(fecha_fin, NOW()) = 3')
            ->with(['empresa.user', 'plan'])
            ->get();

        foreach ($suscripciones3dias as $suscripcion) {
            try {
                $this->enviarRecordatorio($suscripcion, 3, '3dias');
                $enviados++;
                $this->line("✅ Enviado a: {$suscripcion->empresa->nombre_comercial} (3 días)");
            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error enviando a {$suscripcion->empresa->nombre_comercial}: {$e->getMessage()}");
            }
        }

        // 3. Suscripciones que vencen en 1 día
        $this->line('');
        $this->info('🔍 Buscando suscripciones que vencen en 1 día...');
        $suscripciones1dia = Suscripcion::where('estado', 'activa')
            ->whereRaw('DATEDIFF(fecha_fin, NOW()) = 1')
            ->with(['empresa.user', 'plan'])
            ->get();

        foreach ($suscripciones1dia as $suscripcion) {
            try {
                $this->enviarRecordatorio($suscripcion, 1, '1dia');
                $enviados++;
                $this->line("✅ Enviado a: {$suscripcion->empresa->nombre_comercial} (1 día)");
            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error enviando a {$suscripcion->empresa->nombre_comercial}: {$e->getMessage()}");
            }
        }

        // 4. Suscripciones que vencieron hoy
        $this->line('');
        $this->info('🔍 Buscando suscripciones que vencieron hoy...');
        $suscripcionesVencidas = Suscripcion::where('estado', 'activa')
            ->whereRaw('DATE(fecha_fin) = CURDATE()')
            ->with(['empresa.user', 'plan'])
            ->get();

        foreach ($suscripcionesVencidas as $suscripcion) {
            try {
                $this->enviarRecordatorio($suscripcion, 0, 'vencido');
                $enviados++;
                $this->line("✅ Enviado a: {$suscripcion->empresa->nombre_comercial} (vencido)");
            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error enviando a {$suscripcion->empresa->nombre_comercial}: {$e->getMessage()}");
            }
        }

        // Resumen
        $this->line('');
        $this->info('📊 Resumen:');
        $this->line("   ✅ Emails enviados: {$enviados}");
        
        if ($errores > 0) {
            $this->error("   ❌ Errores: {$errores}");
        }

        if ($enviados === 0 && $errores === 0) {
            $this->line('   ℹ️ No hay suscripciones que requieran recordatorio en este momento');
        }

        $this->info('');
        $this->info('🎉 Proceso completado');
        
        return 0;
    }

    /**
     * Enviar recordatorio por email
     */
    private function enviarRecordatorio(Suscripcion $suscripcion, int $diasRestantes, string $tipoAlerta)
    {
        $empresa = $suscripcion->empresa;
        $user = $empresa->user;

        if (!$user || !$user->email) {
            throw new \Exception('Usuario sin email');
        }

        Mail::to($user->email)->send(
            new SuscripcionProximaVencer($empresa, $suscripcion, $diasRestantes, $tipoAlerta)
        );
    }
}
