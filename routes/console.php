<?php

use App\Console\Commands\UpdateAbonnements;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('log:clear', function () {
    array_map('unlink', glob(storage_path('logs/*.log')));
    $this->comment('Logs cleared!');
})->describe('Clear all logs');

Schedule::command('contrat:update-statut')->everyMinute(); // ou ->everyMinute() pour test rapide
Schedule::command('rappel:loyer')->everyMinute();
Schedule::command('payments:check-new')->everyMinute();
Schedule::command('abonnements:update')->everySecond();
// Schedule::command('rappel:abonnement')->dailyAt('09:00');
Schedule::command('rappel:abonnement')->everySecond();


