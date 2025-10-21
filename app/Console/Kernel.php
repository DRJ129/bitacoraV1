<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateReports::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Generar reporte diario a las 00:05
        $schedule->command('reports:generate --daily')->dailyAt('00:05');

        // Generar reporte semanal los domingos a las 00:10
        $schedule->command('reports:generate --weekly')->weeklyOn(0, '00:10');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
