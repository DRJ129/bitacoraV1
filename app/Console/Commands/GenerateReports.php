<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReports extends Command
{
    protected $signature = 'reports:generate {--daily} {--weekly} {--date=}';

    protected $description = 'Generate daily or weekly PDF reports for activities';

    public function handle()
    {
        $date = $this->option('date') ?: now()->toDateString();

        if ($this->option('daily')) {
            $this->generateDaily($date);
        }

        if ($this->option('weekly')) {
            $this->generateWeekly($date);
        }

        $this->info('Reports generated');
        return 0;
    }

    protected function generateDaily($date)
    {
        $activities = Activity::where('date', $date)->orderBy('created_at')->get();
        $pdf = Pdf::loadView('activities.pdf.daily', compact('activities', 'date'));
        $path = storage_path("app/reports/resumen_diario_{$date}.pdf");
        if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
        file_put_contents($path, $pdf->output());
        $this->line("Daily report saved to: {$path}");
    }

    protected function generateWeekly($date)
    {
        $endDate = \Carbon\Carbon::parse($date);
        $startDate = $endDate->copy()->startOfWeek();

        $activities = Activity::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])->orderBy('date')->get();
        $pdf = Pdf::loadView('activities.pdf.weekly', compact('activities', 'startDate', 'endDate'));
        $path = storage_path("app/reports/resumen_semanal_{$startDate->toDateString()}_a_{$endDate->toDateString()}.pdf");
        if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
        file_put_contents($path, $pdf->output());
        $this->line("Weekly report saved to: {$path}");
    }
}
