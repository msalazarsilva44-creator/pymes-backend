<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule): void
    {
        // Verificar suscripciones vencidas todos los días a las 00:00
        $schedule->command('suscripciones:verificar-vencimientos')
                 ->daily()
                 ->at('00:00');

        // Enviar recordatorios de suscripción todos los días a las 09:00
        $schedule->command('suscripciones:enviar-recordatorios')
                 ->daily()
                 ->at('09:00');

        // Limpiar tokens Sanctum expirados diariamente
        $schedule->command('sanctum:prune-expired --hours=24')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

