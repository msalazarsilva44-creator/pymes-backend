<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Suscripcion;
use App\Models\Empresa;
use App\Models\Plan;

class VerificarVencimientosSuscripciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suscripciones:verificar-vencimientos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica y actualiza el estado de suscripciones vencidas, revertiendo empresas al plan Gratis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando suscripciones vencidas...');
        
        // Buscar suscripciones activas que ya vencieron
        $suscripcionesVencidas = Suscripcion::where('estado', 'activa')
            ->where('fecha_fin', '<', now())
            ->with('empresa')
            ->get();

        if ($suscripcionesVencidas->isEmpty()) {
            $this->info('✅ No hay suscripciones vencidas.');
            return 0;
        }

        $this->info("📋 Encontradas {$suscripcionesVencidas->count()} suscripción(es) vencida(s)");
        
        // Obtener el plan Gratis
        $planGratis = Plan::where('slug', 'gratis')->first();
        
        if (!$planGratis) {
            $this->error('❌ Error: No se encontró el plan Gratis en la base de datos');
            return 1;
        }

        $procesadas = 0;
        $errores = 0;

        // Procesar cada suscripción vencida
        foreach ($suscripcionesVencidas as $suscripcion) {
            try {
                $empresa = $suscripcion->empresa;
                
                if (!$empresa) {
                    $this->warn("⚠️ Suscripción #{$suscripcion->id}: Empresa no encontrada");
                    continue;
                }

                // Actualizar estado de la suscripción
                $suscripcion->update(['estado' => 'vencida']);
                
                // Revertir empresa al plan Gratis
                $empresa->update(['plan_id' => $planGratis->id]);
                
                // Remover boost si tiene
                if ($empresa->boost_hasta) {
                    $empresa->update(['boost_hasta' => null]);
                }

                $this->line("✅ Empresa #{$empresa->id} ({$empresa->nombre_comercial}): Plan revertido a Gratis");
                $procesadas++;

            } catch (\Exception $e) {
                $this->error("❌ Error procesando suscripción #{$suscripcion->id}: {$e->getMessage()}");
                $errores++;
            }
        }

        $this->newLine();
        $this->info("📊 Resumen:");
        $this->info("   ✅ Procesadas: {$procesadas}");
        
        if ($errores > 0) {
            $this->error("   ❌ Errores: {$errores}");
        }

        $this->info('🎉 Proceso completado');
        
        return 0;
    }
}
